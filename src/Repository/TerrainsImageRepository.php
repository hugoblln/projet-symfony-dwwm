<?php

namespace App\Repository;

use App\Entity\TerrainsImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TerrainsImage>
 *
 * @method TerrainsImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TerrainsImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TerrainsImage[]    findAll()
 * @method TerrainsImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TerrainsImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TerrainsImage::class);
    }

    //    /**
    //     * @return TerrainsImage[] Returns an array of TerrainsImage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?TerrainsImage
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
