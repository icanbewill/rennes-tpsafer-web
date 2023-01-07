<?php

namespace App\Controller;

use App\Entity\Favourite;
use App\Entity\Property;
use App\Form\FavouriteType;
use App\Repository\FavouriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class FavouriteController extends AbstractController
{

    private $em;
    private $favouriteRepository;
    public function __construct(EntityManagerInterface $em, FavouriteRepository $favouriteRepository)
    {
        $this->em = $em;
        $this->favouriteRepository = $favouriteRepository;
    }

    /**
     * Récupère toutes les propriétés favoris non envoyées en utilisant la classe PropertyRepository et les affiche dans le template views/property/index.html.twig.
     * @Route("/favourite", name="app_favourite_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('views/favourite/index.html.twig', [
            'favourites' => $this->favouriteRepository->findBy(array('isSent' => false)),
        ]);
    }

    /**
     * @Route("/my-favourites", name="app_favourite_list", methods={"GET", "POST"})
     */
    public function list(Request $request): Response
    {
        $session = $request->getSession();
        $userMail = $session->get('email');
        if (!$userMail) {
            $favourite = new Favourite();
            $form = $this->createForm(FavouriteType::class, $favourite);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $userMail = $form->getData()->getEmail();
                $session->set('email', $userMail);
                $favourites = $this->favouriteRepository->findBy(array('email' => $userMail, 'isSent' => false));
            } else {
                return $this->renderForm('views/favourite/registersession.html.twig', [
                    'favourite' => $favourite,
                    'form' => $form,
                ]);
            }
        } else {
            // $favourites = $this->favouriteRepository->findAll();
            $favourites = $this->favouriteRepository->findBy(array('email' => $userMail, 'isSent' => false));
        }

        return $this->render('landing/favourites.html.twig', [
            'properties' => $favourites
        ]);
    }

    /**
     * Cette fonction envoie les favoris par mail, en se basant sur l'email en session
     * @Route("/favourite/mail", name="app_favourite_mail", methods={"GET", "POST"})
     */
    public function sendMail(Request $request, MailerInterface $mailer)
    {
        $session = $request->getSession();
        $userMail = $session->get('email');
        if ($userMail) {
            $favourites = $this->favouriteRepository->findBy(array('email' => $userMail, 'isSent' => false));
            try {
                $email = (new TemplatedEmail())
                    ->from('safer@example.com')
                    ->to($userMail)
                    ->subject('Biens favoris')
                    ->htmlTemplate('emails/favourites.html.twig')
                    ->context([
                        'properties' => $favourites,
                        'message' => "Veuillez retrouver ci-dessous la liste de vos favoris."
                    ]);
                $mailer->send($email);

                foreach ($favourites as $key => $favourite) {
                    $favourite->setIsSent(true);
                    $this->em->persist($favourite);
                }
                $this->em->flush();

                $this->addFlash(
                    'success',
                    'Bien envoyés par mail avec succès !'
                );
            } catch (\Throwable $th) {
                //throw $th;
                dd($th);
            }
        }

        return $this->redirectToRoute('app_favourite_list', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/favourite/new/{id}", name="app_favourite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, Property $property): Response
    {
        $session = $request->getSession();
        $userMail = $session->get('email');
        if (!$userMail) {
            $favourite = new Favourite();
            $form = $this->createForm(FavouriteType::class, $favourite);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $userMail = $form->getData()->getEmail();
                $session->set('email', $userMail);
                return $this->addFavourite($property, $userMail);
            } else {
                return $this->renderForm('views/favourite/registersession.html.twig', [
                    'favourite' => $favourite,
                    'form' => $form,
                ]);
            }
        } else {
            return $this->addFavourite($property, $userMail);
        }
    }

    /** Ajout d'un bien en favoris */
    public function addFavourite(Property $property, $userMail)
    {
        $favourite = $this->favouriteRepository->findBy(array('email' => $userMail, 'bien_id' => $property->getId()));
        if ($favourite) {
            $this->addFlash(
                'danger',
                'Ce bien existe déja dans vos favoris !'
            );
        } else {
            // Ensuite on crée un nouveau favoris
            $favourite = new Favourite();
            $favourite->setEmail($userMail);
            $favourite->setBienId($property);
            $favourite->setIsSent(false);
            $favourite->setCreatedAt(new \DateTimeImmutable());
            $this->em->persist($favourite);
            $this->em->flush();

            $this->addFlash(
                'success',
                'Bien ajouté avec succès !'
            );
        }

        return $this->redirectToRoute('app_favourite_list', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/favourite/{id}", name="app_favourite_show", methods={"GET"})
     */
    public function show(Favourite $favourite): Response
    {
        return $this->render('views/favourite/show.html.twig', [
            'favourite' => $favourite,
        ]);
    }

    /**
     * @Route("/favourite/{id}/edit", name="app_favourite_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Favourite $favourite, FavouriteRepository $favouriteRepository): Response
    {
        $form = $this->createForm(FavouriteType::class, $favourite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $favouriteRepository->add($favourite, true);

            return $this->redirectToRoute('app_favourite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('views/favourite/edit.html.twig', [
            'favourite' => $favourite,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/favourite/{id}", name="app_favourite_delete", methods={"POST"})
     */
    public function delete(Request $request, Favourite $favourite): Response
    {
        if ($this->isCsrfTokenValid('delete' . $favourite->getId(), $request->request->get('_token'))) {
            $this->favouriteRepository->remove($favourite, true);

            $this->addFlash(
                'success',
                'Bien retiré avec succès !'
            );
        }

        return $this->redirectToRoute('app_favourite_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Suppression d'un bien des favoris, par l'utilisateur lui-même
     * @Route("/favourite/remove/{id}", name="app_favourite_remove", methods={"GET"})
     */
    public function remove(Request $request, Favourite $favourite): Response
    {
        $this->favouriteRepository->remove($favourite, true);

        $this->addFlash(
            'success',
            'Bien retiré avec succès !'
        );

        return $this->redirectToRoute('app_favourite_list', [], Response::HTTP_SEE_OTHER);
    }
}
