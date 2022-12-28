<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\SearchedProperty;
use App\Entity\User;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        $properties = $propertyRepository->getSome();

        // totalUsers
        $repoUsers = $em->getRepository(User::class);
        $totalUser = $repoUsers->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // totalCategories
        $repoCategories = $em->getRepository(Category::class);
        $totalCategories = $repoCategories->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // totalProperties
        $repoProperties = $em->getRepository(Property::class);
        $totalProperties = $repoProperties->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        // totalResearches
        $repoRes = $em->getRepository(SearchedProperty::class);
        $totalResearches = $repoRes->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        return $this->render('views/dashboard/index.html.twig', [
            'totalUser' => $totalUser,
            'totalProperties' => $totalProperties,
            'totalCategories' => $totalCategories,
            'totalResearches' => $totalResearches,
            'properties' => $properties,
        ]);
    }
}
