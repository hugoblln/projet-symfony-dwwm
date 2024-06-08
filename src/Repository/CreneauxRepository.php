<?php

namespace App\Repository;

use App\Entity\Creneaux;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Creneaux>
 *
 * @method Creneaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creneaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creneaux[]    findAll()
 * @method Creneaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreneauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creneaux::class);
    }

    public function findCreneauxComplexe(int $complexeId ) : array 
    {
     
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
    SELECT CONCAT(c.debut,\' \', c.fin) as creneau
    FROM creneaux c
    CROSS JOIN complexes co
    WHERE c.debut BETWEEN co.heure_ouverture AND co.heure_fermeture - 1
    AND co.id = :complexeId;
    ';

    $resultSet = $conn->executeQuery($sql, ['complexeId' => $complexeId]);

    $result = $resultSet->fetchAll();

    return $result ?? [];

    }

    //    /**
    //     * @return Creneaux[] Returns an array of Creneaux objects
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

    //    public function findOneBySomeField($value): ?Creneaux
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
