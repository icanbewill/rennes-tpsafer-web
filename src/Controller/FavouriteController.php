<?php

namespace App\Controller;

use App\Entity\Favourite;
use App\Form\FavouriteType;
use App\Repository\FavouriteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/favourite")
 */
class FavouriteController extends AbstractController
{
    /**
     * @Route("/", name="app_favourite_index", methods={"GET"})
     */
    public function index(FavouriteRepository $favouriteRepository): Response
    {
        // dd($favouriteRepository->findAll());
        return $this->render('views/favourite/index.html.twig', [
            'favourites' => $favouriteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_favourite_new", methods={"GET", "POST"})
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
     * @Route("/{id}", name="app_favourite_show", methods={"GET"})
     */
    public function show(Favourite $favourite): Response
    {
        return $this->render('views/favourite/show.html.twig', [
            'favourite' => $favourite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_favourite_edit", methods={"GET", "POST"})
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
     * @Route("/{id}", name="app_favourite_delete", methods={"POST"})
     */
    public function delete(Request $request, Favourite $favourite, FavouriteRepository $favouriteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$favourite->getId(), $request->request->get('_token'))) {
            $favouriteRepository->remove($favourite, true);
        }

        return $this->redirectToRoute('app_favourite_index', [], Response::HTTP_SEE_OTHER);
    }
}
