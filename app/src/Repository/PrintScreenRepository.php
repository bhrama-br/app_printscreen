<?php

namespace App\Repository;

use App\Entity\PrintScreen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrintScreen|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrintScreen|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrintScreen[]    findAll()
 * @method PrintScreen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrintScreenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrintScreen::class);
    }

    // /**
    //  * @return PrintScreen[] Returns an array of PrintScreen objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrintScreen
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
