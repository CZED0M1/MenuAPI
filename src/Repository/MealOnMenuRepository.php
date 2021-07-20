<?php

namespace App\Repository;

use App\Entity\MealOnMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MealOnMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method MealOnMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method MealOnMenu[]    findAll()
 * @method MealOnMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealOnMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MealOnMenu::class);
    }

    // /**
    //  * @return MealOnMenu[] Returns an array of MealOnMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MealOnMenu
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
