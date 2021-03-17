<?php

namespace App\Repository;

use App\Entity\TrainingManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TrainingManager|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrainingManager|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrainingManager[]    findAll()
 * @method TrainingManager[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrainingManagerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrainingManager::class);
    }

    // /**
    //  * @return TrainingManager[] Returns an array of TrainingManager objects
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
    public function findOneBySomeField($value): ?TrainingManager
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
