<?php

namespace App\Repository;

use App\Entity\Complexes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Complexes>
 *
 * @method Complexes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Complexes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Complexes[]    findAll()
 * @method Complexes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComplexesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Complexes::class);
    }

    //    /**
    //     * @return Complexes[] Returns an array of Complexes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Complexes
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
