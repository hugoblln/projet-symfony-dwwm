<?php

namespace App\Repository;

use App\Entity\TarifHeure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TarifHeure>
 *
 * @method TarifHeure|null find($id, $lockMode = null, $lockVersion = null)
 * @method TarifHeure|null findOneBy(array $criteria, array $orderBy = null)
 * @method TarifHeure[]    findAll()
 * @method TarifHeure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TarifHeureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TarifHeure::class);
    }

    //    /**
    //     * @return TarifHeure[] Returns an array of TarifHeure objects
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

    //    public function findOneBySomeField($value): ?TarifHeure
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
