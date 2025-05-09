<?php

namespace App\Repository;

use App\Entity\Terrains;
use App\Filter\TerrainFilter;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function FindAllOrderByName(): array
    {
        return $this->createQueryBuilder('t')
            ->orderBy('t.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function FindAllEnableByDate(): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.enable = :enable')
            ->setParameter('enable', true)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByVille(string $ville): array
    {
        return $this->createQueryBuilder('t')
            ->join('t.complexe', 'c') // Joindre avec l'entité Complexes
            ->andWhere('c.Ville = :ville')
            ->setParameter('ville', $ville)
            ->getQuery()
            ->getResult();
    }


    public function findByComplexe(int $complexeId): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.complexe = :complexeId')
            ->setParameter('complexeId', $complexeId)
            ->getQuery()
            ->getResult();
    }

    public function findTypesTerrains(): array
    {
        return $this->createQueryBuilder('t')
            ->select('DISTINCT t.typeTerrain')
            ->getQuery()
            ->getResult();
    }

    public function findByFilter(TerrainFilter $filter)
    {
        $qb = $this->createQueryBuilder('t')
            ->join('t.complexe', 'c') // Joindre l'entité Complexe avec l'alias 'c'
            ->addSelect('c') // Optionnel: sélectionner également les données du complexe
            ->andWhere('t.enable = :enable')
            ->setParameter('enable', true);

        if ($filter->getQuery()) {
            $qb->andWhere('c.nom LIKE :query OR c.description LIKE :query')
                ->setParameter('query', '%' . $filter->getQuery() . '%');
        }

        if ($filter->getMin()) {
            $qb->andWhere('t.tarifHeure >= :min')
                ->setParameter('min', $filter->getMin());
        }

        if ($filter->getMax()) {
            $qb->andWhere('t.tarifHeure <= :max')
                ->setParameter('max', $filter->getMax());
        }

        if ($filter->getVille()) {
            $qb->andWhere('c.Ville = :ville')
                ->setParameter('ville', $filter->getVille());
        }

        if ($filter->getTypeTerrain()) {
            $qb->andWhere('t.typeTerrain IN (:typeTerrain)')
                ->setParameter('typeTerrain', $filter->getTypeTerrain());
        }

        return $qb->getQuery()->getResult();
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
