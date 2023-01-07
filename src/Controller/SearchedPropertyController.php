<?php

namespace App\Controller;

use App\Entity\SearchedProperty;
use App\Form\SearchedPropertyType;
use App\Repository\SearchedPropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchedPropertyController extends AbstractController
{
    /**
     * @Route("/searched/property", name="app_searched_property_index", methods={"GET"})
     */
    public function index(SearchedPropertyRepository $searchedPropertyRepository): Response
    {
        return $this->render('views/searched_property/index.html.twig', [
            'searched_properties' => $searchedPropertyRepository->findAll(),
        ]);
    }

    /**
     * Cette méthode permet d'enregistrer une recherche particulière d'un utilisaeteur, 
     * pour se faire prévenir quand un bien est disponible
     * 
     * 
     * @Route("/searchproperty", name="app_searched_property_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SearchedPropertyRepository $searchedPropertyRepository): Response
    {
        $searchedProperty = new SearchedProperty();
        $form = $this->createForm(SearchedPropertyType::class, $searchedProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchedPropertyRepository->add($searchedProperty, true);

            $this->addFlash(
                'success',
                'Demande enregistrée avec succès!'
            );
            return $this->redirectToRoute('app_searched_property_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('landing/searchproperty.html.twig', [
            'searched_property' => $searchedProperty,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/searched/property/{id}", name="app_searched_property_show", methods={"GET"})
     */
    public function show(SearchedProperty $searchedProperty): Response
    {
        return $this->render('views/searched_property/show.html.twig', [
            'searched_property' => $searchedProperty,
        ]);
    }

    /**
     * @Route("/searched/property/{id}/edit", name="app_searched_property_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SearchedProperty $searchedProperty, SearchedPropertyRepository $searchedPropertyRepository): Response
    {
        $form = $this->createForm(SearchedPropertyType::class, $searchedProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchedPropertyRepository->add($searchedProperty, true);

            return $this->redirectToRoute('app_searched_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('views/searched_property/edit.html.twig', [
            'searched_property' => $searchedProperty,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/searched/property/{id}", name="app_searched_property_delete", methods={"POST"})
     */
    public function delete(Request $request, SearchedProperty $searchedProperty, SearchedPropertyRepository $searchedPropertyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$searchedProperty->getId(), $request->request->get('_token'))) {
            $searchedPropertyRepository->remove($searchedProperty, true);
        }

        return $this->redirectToRoute('app_searched_property_index', [], Response::HTTP_SEE_OTHER);
    }
}
