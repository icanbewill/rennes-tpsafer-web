<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\ResultSetMapping;

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
    public function index(CategoryRepository $categoryRepository): Response
    {
        $sql = 'SELECT * from property ORDER BY RAND() LIMIT 3';
        $em = $this->getDoctrine()->getManager();
        $statement = $em->getConnection()->prepare($sql);
        $result = $statement->execute()->fetchAll();

        foreach ($result as $key => $value) {
            $properties[] = $value;
        }

        return $this->render('landing/index.html.twig', [
            'properties' => $properties,
            'categories' => $categoryRepository->findAll(),
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
            'category' => $category,
            'properties' => $properties
        ]);
    }
}
