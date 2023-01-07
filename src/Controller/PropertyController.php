<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Form\SearchDataForm;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use App\Repository\SearchedPropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/property")
 */
class PropertyController extends AbstractController
{
    private $security;
    private $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }


    /**
     * La méthode index récupère toutes les propriétés en utilisant la classe 
     * PropertyRepository et les affiche dans le template views/property/index.html.twig
     * 
     * 
     * @Route("/", name="app_property_index", methods={"GET"})
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('views/property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }
    /**
     * La méthode properties récupère toutes les propriétés et les catégories en 
     * utilisant les classes PropertyRepository et CategoryRepository 
     * et les affiche dans le template landing/property/all.html.twig. 
     * Elle crée également et gère un formulaire de recherche de propriétés.
     * 
     * 
     * @Route("/all", name="app_property_all", methods={"GET"})
     */
    public function properties(Request $request, PropertyRepository $propertyRepository, CategoryRepository $categoryRepository): Response
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataForm::class, $data);
        $form->handleRequest($request);

        return $this->render('landing/property/all.html.twig', [
            'properties' => $propertyRepository->findAll(),
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * La méthode new permet à un utilisateur de créer une nouvelle propriété en 
     * gérant la soumission d'un formulaire. Elle gère également les téléchargements 
     * de fichiers pour l'image de la propriété et vérifie s'il y a des utilisateurs 
     * qui recherchent actuellement des propriétés qui correspondent à la nouvelle 
     * propriété créée. Si c'est le cas, elle envoie un email à ces utilisateurs.
     * 
     * 
     * @Route("/new", name="app_property_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PropertyRepository $propertyRepository, SluggerInterface $slugger, SearchedPropertyRepository $searchedPropertyRepository): Response
    {
        $user = $this->security->getUser();
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $searchedProperties = $searchedPropertyRepository->findByFilter($property);
            $propertyRepository->add($property, false);

            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/property_images';

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                // telechargement de fichier
                try {
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // Envoyer de mail à tout ceux qui recherchent un bien pareil


                $property->setImage($newFilename);
            }

            // if (count($searchedProperties)) {
            // }

            $this->addFlash(
                'success',
                'Enregistrement effectué avec succès!'
            );

            $property->setAddedBy($user);
            $property->setReference($this->generateRandomString());
            $this->em->persist($property);
            $this->em->flush();

            return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('views/property/new.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    /** Génération de référence aléatoire */
    public function generateRandomString($length = 8)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * @Route("/{id}", name="app_property_show", methods={"GET"})
     */
    public function show(Property $property): Response
    {
        $category = $this->getDoctrine()->getRepository('App\Entity\Category')->findBy(['id' => $property->getCategoryId()]);
        // dd($sections);
        return $this->render('views/property/show.html.twig', [
            'property' => $property,
            'category' => $category ? $category[0] : null,
        ]);
    }

    /**
     * Affichge sur la landing des details d'un bien
     * @Route("/details/{id}", name="app_property_details", methods={"GET"})
     */
    public function details(Property $property): Response
    {
        return $this->render('landing/property/details.html.twig', [
            'property' => $property,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_property_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Property $property, PropertyRepository $propertyRepository, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $propertyRepository->add($property, true);

            $uploadedFile = $form['imageFile']->getData();
            if ($uploadedFile) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/property_images';

                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                // telechargement de fichier
                try {
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $property->setImage($newFilename);
                $this->addFlash(
                    'success',
                    'Enregistrement effectué avec succès!'
                );
            }
            $this->em->persist($property);
            $this->em->flush();
            return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('views/property/edit.html.twig', [
            'property' => $property,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_property_delete", methods={"POST"})
     */
    public function delete(Request $request, Property $property, PropertyRepository $propertyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->request->get('_token'))) {
            $propertyRepository->remove($property, true);
        }

        return $this->redirectToRoute('app_property_index', [], Response::HTTP_SEE_OTHER);
    }
}
