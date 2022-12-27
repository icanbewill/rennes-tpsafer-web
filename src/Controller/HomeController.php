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

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('App\Entity\Property');
        $quantity = 3; // Nombre d'élements à sélectionner
        $totalRowsTable = $repo->createQueryBuilder('a')->select('count(a.id)')->getQuery()->getSingleScalarResult(); // This will be in this case 10 because i have 10 records on this table
        // dd($totalRowsTable);
        $random_ids = $this->UniqueRandomNumbersWithinRange(1, $totalRowsTable, $quantity);
        // dd($random_ids);
        $properties = $repo->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $random_ids)
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
        dd($properties);
        return $this->render('landing/index.html.twig', [
            'properties' => $properties,
        ]);
    }

    public function UniqueRandomNumbersWithinRange($min, $max, $quantity)
    {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
}
