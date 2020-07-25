<?php

namespace App\Repository;

use App\Entity\RessourceConnexe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RessourceConnexe|null find($id, $lockMode = null, $lockVersion = null)
 * @method RessourceConnexe|null findOneBy(array $criteria, array $orderBy = null)
 * @method RessourceConnexe[]    findAll()
 * @method RessourceConnexe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RessourceConnexeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RessourceConnexe::class);
    }

    // /**
    //  * @return RessourceConnexe[] Returns an array of RessourceConnexe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RessourceConnexe
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
