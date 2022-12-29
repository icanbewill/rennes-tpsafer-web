<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchDataForm;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use ContainerAgr3dtg\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    private $em;
    private $propertyRepository;

    public function __construct(EntityManagerInterface $em, PropertyRepository $propertyRepository)
    {
        $this->em = $em;
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepository, Request $request): Response
    {
        $sql = 'SELECT * from property ORDER BY RAND() LIMIT 3';
        $em = $this->getDoctrine()->getManager();
        $statement = $em->getConnection()->prepare($sql);
        $result = $statement->execute()->fetchAll();

        $properties = [];
        
        foreach ($result as $key => $value) {
            $properties[] = $value;
        }

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataForm::class, $data);
        $form->handleRequest($request);

        return $this->render('landing/index.html.twig', [
            'properties' => $properties,
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/categories/{name}", name="app_category_items", methods={"GET"})
     */
    public function list($name, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(array('libelle' => $name));
        $properties = $category->getProperties();
        return $this->render('landing/properties.html.twig', [
            'view' => 'list_category',
            'category' => $category,
            'properties' => $properties
        ]);
    }

    /**
     * @Route("/search", name="app_search")
     */
    public function search(PropertyRepository $repository, Request $request)
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataForm::class, $data);
        $form->handleRequest($request);
        $properties = $repository->findSearch($data);
        // dd($properties);
        return $this->render('landing/properties.html.twig', [
            'view' => 'filter',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }
}
