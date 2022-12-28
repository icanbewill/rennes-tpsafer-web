<?php

namespace App\Controller;

use App\Entity\Favourite;
use App\Form\FavouriteType;
use App\Repository\FavouriteRepository;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class FavouriteController extends AbstractController
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/favourite", name="app_favourite_index", methods={"GET"})
     */
    public function index(FavouriteRepository $favouriteRepository): Response
    {
        return $this->render('views/favourite/index.html.twig', [
            'favourites' => $favouriteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/my-favourites", name="app_favourite_list", methods={"GET"})
     */
    public function list(): Response
    {
        return $this->render('landing/favourites.html.twig');
    }

    /**
     * @Route("/favourite/mail", name="app_favourite_mail", methods={"GET", "POST"})
     */
    public function sendMail(Request $request, FavouriteRepository $fr, PropertyRepository $pr, MailerInterface $mailer)
    {
        $toEmail = "aaa@aa.aa";
        $properties = $request->toArray();
        foreach ($properties as $key => $property) {
            // D'abord on retrouve le bien
            $foundProperty = $pr->findOneBy(array('id' => $property['id']));
            // Ensuite on crée un nouveau favoris envoyé par mail
            $favourite = new Favourite();
            $favourite->setEmail("aaa");
            $favourite->setBienId($foundProperty);
            $favourite->setCreatedAt(new \DateTimeImmutable());
            // on le persiste
            $this->em->persist($favourite);
        }
        $this->em->flush();



        $email = (new TemplatedEmail())
            ->from('safer@example.com')
            ->to($toEmail)
            ->subject('Biens favoris')
            ->htmlTemplate('emails/favourites.html.twig')
            ->context([
                'properties' => $properties
            ]);
        $mailer->send($email);

        $response = new JsonResponse($properties);
        return $response;
    }
    /**
     * @Route("/favourite/new", name="app_favourite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FavouriteRepository $favouriteRepository): Response
    {
        $favourite = new Favourite();
        $form = $this->createForm(FavouriteType::class, $favourite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $favouriteRepository->add($favourite, true);

            return $this->redirectToRoute('app_favourite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('views/favourite/new.html.twig', [
            'favourite' => $favourite,
            'form' => $form,
        ]);
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
    public function delete(Request $request, Favourite $favourite, FavouriteRepository $favouriteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $favourite->getId(), $request->request->get('_token'))) {
            $favouriteRepository->remove($favourite, true);
        }

        return $this->redirectToRoute('app_favourite_index', [], Response::HTTP_SEE_OTHER);
    }
}
