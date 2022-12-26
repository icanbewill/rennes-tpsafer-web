<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Form\BienType;
use App\Repository\BienRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/bien")
 */
class BienController extends AbstractController
{
    private $security;
    private $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        // $user = $this->security->getUser();
        $this->em = $em;
    }
    
    /**
     * @Route("/", name="app_bien_index", methods={"GET"})
     */
    public function index(BienRepository $bienRepository): Response
    {
        return $this->render('views/bien/index.html.twig', [
            'biens' => $bienRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_bien_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BienRepository $bienRepository, SluggerInterface $slugger): Response
    {
        $bien = new Bien();
        $form = $this->createForm(BienType::class, $bien);
        $form->handleRequest($request);
        // $entityManager = $e->getManager();

        if ($form->isSubmitted() && $form->isValid()) {
            $bienRepository->add($bien, true);

            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir').'/public/uploads/property_images';
                
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

                try {
                    $uploadedFile->move(
                       $destination,
                        $newFilename
                    );
                    
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $bien->setFileName($newFilename);
                $this->em->persist($bien);
                $this->em->flush();
            }

            return $this->redirectToRoute('app_bien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('views/bien/new.html.twig', [
            'bien' => $bien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_bien_show", methods={"GET"})
     */
    public function show(Bien $bien): Response
    {
        return $this->render('views/bien/show.html.twig', [
            'bien' => $bien,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_bien_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Bien $bien, BienRepository $bienRepository): Response
    {
        $form = $this->createForm(BienType::class, $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bienRepository->add($bien, true);

            return $this->redirectToRoute('app_bien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('views/bien/edit.html.twig', [
            'bien' => $bien,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_bien_delete", methods={"POST"})
     */
    public function delete(Request $request, Bien $bien, BienRepository $bienRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bien->getId(), $request->request->get('_token'))) {
            $bienRepository->remove($bien, true);
        }

        return $this->redirectToRoute('app_bien_index', [], Response::HTTP_SEE_OTHER);
    }
}
