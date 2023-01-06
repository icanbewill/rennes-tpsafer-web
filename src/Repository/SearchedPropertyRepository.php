<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\SearchedProperty;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SearchedProperty>
 *
 * @method SearchedProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method SearchedProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method SearchedProperty[]    findAll()
 * @method SearchedProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchedPropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchedProperty::class);
    }

    public function add(SearchedProperty $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SearchedProperty $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Récupère les produits en lien avec une recherche
     */
    public function findSearch(Property $search)
    {
        $query = $this->getSearchQuery($search)->getQuery();
        return $query->getResult();
    }


    private function getSearchQuery(Property $search): QueryBuilder
    {
        $query = $this
            ->createQueryBuilder('p')
            ->select('c', 'p');
        // ->join('p.category_id', 'c');

        if (!empty($search->type)) {
            $query = $query
                ->andWhere('p.type = :type')
                ->setParameter('type', $search->type);
        }

        if (!empty($search->minprice)) {
            $query = $query
                ->andWhere('p.minprice >= :minprice')
                ->setParameter('minprice', $search->minprice);
        }

        if (!empty($search->pricemax)) {
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

        return $query;
    }

    //    /**
    //     * @return SearchedProperty[] Returns an array of SearchedProperty objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    /**
     * @return SearchedProperty[] Returns an array of SearchedProperty objects
     */
    public function findByFilter(Property $property): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.minprice <= :minprice')
            ->setParameter('minprice', $property->getPrice())

            ->andWhere('s.maxprice >= :maxprice')
            ->setParameter('maxprice', $property->getPrice())

            // ->andWhere('s.minsurface <= :minsurface')
            // ->setParameter('minsurface', $property->getSurface())

            // ->andWhere('s.maxsurface <= :maxsurface')
            // ->setParameter('maxsurface', $property->getSurface())

            // ->andWhere('s.type <= :type')
            // ->setParameter('type', $property->getType())

            // ->andWhere('s.country = :country')
            // ->setParameter('country', $property->getCountry())
            // ->groupBy("s.email")
            // ->orderBy('s.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?SearchedProperty
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
