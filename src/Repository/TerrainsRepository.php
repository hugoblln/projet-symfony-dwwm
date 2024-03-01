<?php

namespace App\Repository;

use App\Entity\Terrains;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Terrains>
 *
 * @method Terrains|null find($id, $lockMode = null, $lockVersion = null)
 * @method Terrains|null findOneBy(array $criteria, array $orderBy = null)
 * @method Terrains[]    findAll()
 * @method Terrains[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrainsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrains::class);
    }

    //    /**
    //     * @return Terrains[] Returns an array of Terrains objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Terrains
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
