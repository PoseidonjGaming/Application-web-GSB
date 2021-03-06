<?php

namespace App\Repository;

use App\Entity\Fiche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Fiche|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fiche|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fiche[]    findAll()
 * @method Fiche[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fiche::class);
    }

    // /**
    //  * @return Fiche[] Returns an array of Fiche objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Fiche
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
	public function findLastFiche($id)
    {
        return $this->createQueryBuilder('s')
        ->andWhere('s.visiteur = :id')
        ->setParameter('id',$id)
        ->orderBy('s.mois', 'DESC')
        ->setMaxResults(1)
        ->getQuery()
        ->getResult();
    }

    public function findUneFiche($idV, $mois)
    {
        return $this->createQueryBuilder('f')
        ->Where('f.visiteur = :id')
        ->andWhere('f.mois like :mois')
        ->setParameter('id',$idV)
        ->setParameter('mois',$mois."%")
        ->getQuery()
        ->getOneOrNullResult();
    }
}
