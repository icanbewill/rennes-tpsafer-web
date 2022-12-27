<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index(): Response
    {
        // $category = $this->getDoctrine()->getRepository('App\Entity\Category')->findBy(['id' => $property->getCategoryId()]);
        // $properties = $this->propertyRepository->getRandom();
        $entityManager = $this->em;
        $query = $entityManager->createQuery("SELECT q  FROM App\Entity\Property q order by RAND() LIMIT 3 ");
        $properties = $query->execute();
        dd($properties);

        return $this->render('landing/index.html.twig', [
            'properties' => $properties,
        ]);
    }
}
