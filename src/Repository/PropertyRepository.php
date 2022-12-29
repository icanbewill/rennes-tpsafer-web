<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Property;
use ContainerAgr3dtg\PaginatorInterface_82dac15;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function add(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère les produits en lien avec une recherche
     */
    public function findSearch(SearchData $search)
    {
        $query = $this->getSearchQuery($search)->getQuery();
        return $query->getResult();
        // return $paginator->paginate(
        //     $query,
        //     $search->page,
        //     9
        // );
    }

    /**
     * Récupère le prix minimum et maximum correspondant à une recherche
     * @return integer[]
     */
    public function findMinMax(SearchData $search): array
    {
        $results = $this->getSearchQuery($search, true)
            ->select('MIN(p.price) as min', 'MAX(p.price) as max')
            ->getQuery()
            ->getScalarResult();
        return [(int)$results[0]['min'], (int)$results[0]['max']];
    }

    private function getSearchQuery(SearchData $search, $ignorePrice = false): QueryBuilder
    {
        // dd($search->categories);
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p')
            ->join('p.category_id', 'c');

        if (!empty($search->q)) {
            $query = $query
                ->andWhere('p.title LIKE :q')
                ->setParameter('q', "%{$search->q}%");
        }

        if (!empty($search->type)) {
            $query = $query
                ->andWhere('p.type = :type')
                ->setParameter('type', $search->type);
        }

        if (!empty($search->pricemin) && $ignorePrice === false) {
            $query = $query
                ->andWhere('p.price >= :pricemin')
                ->setParameter('pricemin', $search->pricemin);
        }

        if (!empty($search->pricemax) && $ignorePrice === false) {
            $query = $query
                ->andWhere('p.price <= :pricemax')
                ->setParameter('pricemax', $search->pricemax);
        }

        if (!empty($search->surfacemin)) {
            $query = $query
                ->andWhere('p.surface >= :surfacemin')
                ->setParameter('surfacemin', $search->surfacemin);
        }

        if (!empty($search->surfacemax)) {
            $query = $query
                ->andWhere('p.surface <= :surfacemax')
                ->setParameter('surfacemax', $search->surfacemax);
        }

        if (!empty($search->categories)) {
            $query = $query
                ->andWhere('c.libelle = :cat')
                ->setParameter('cat', $search->categories);
        }

        // if (!empty($search->categories)) {
        //     $query = $query
        //         ->andWhere('c.id IN (:categories)')
        //         ->setParameter('categories', $search->categories);
        // }

        return $query;
    }


    //    /**
    //     * @return Property[] Returns an array of Property objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Property
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getSome(): array
    {
        return $this->createQueryBuilder('p')
         //    ->andWhere('p.exampleField = :val')
         //    ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
}
