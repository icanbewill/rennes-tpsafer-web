<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Property;
use App\Entity\SearchedProperty;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use phpDocumentor\Reflection\Types\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(CategoryRepository $categoryRepository): Response
    {
        $em = $this->getDoctrine()->getManager();

        // $properties = $propertyRepository->getSome();

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


        $em = $this->getDoctrine()->getManager();

        // Catégories les plus ajoutés favoris
        $sql_categories_fav = 'SELECT i.category_id_id, COUNT(*) AS count
        FROM favourite f
        INNER JOIN property i ON f.bien_id_id = i.id
        GROUP BY i.category_id_id 
        ORDER BY count DESC LIMIT 5';
        $statement_cat = $em->getConnection()->prepare($sql_categories_fav);
        $categoriesGot = $statement_cat->execute()->fetchAll();
        $categories = [];
        foreach ($categoriesGot as $key => $value) {
            $category = new Object_();
            $category->libelle = $categoryRepository->findOneBy(array('id' => $value['category_id_id']))->getLibelle();
            $category->count = $value['count'];
            $categories[] = $category;
        }

        // Produits les plus ajoutés favoris
        $sql_categories_property = 'SELECT i.*, COUNT(*) AS count
        FROM favourite f
        INNER JOIN property i ON f.bien_id_id = i.id
        GROUP BY f.bien_id_id
        ORDER BY count DESC LIMIT 5';
        $statement_pro = $em->getConnection()->prepare($sql_categories_property);
        $properties = $statement_pro->execute()->fetchAll();

        return $this->render('views/dashboard/index.html.twig', [
            'totalUser' => $totalUser,
            'totalProperties' => $totalProperties,
            'totalCategories' => $totalCategories,
            'totalResearches' => $totalResearches,
            'categories' => $categories,
            'properties' => $properties,
        ]);
    }
}
