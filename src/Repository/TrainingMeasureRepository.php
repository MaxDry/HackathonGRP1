<?php

namespace App\Repository;

use App\Entity\TrainingMeasure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainingMeasure|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingMeasure|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingMeasure[]    findAll()
 * @method TrainingMeasure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingMeasureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingMeasure::class);
    }

    // /**
    //  * @return TrainingMeasure[] Returns an array of TrainingMeasure objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TrainingMeasure
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
