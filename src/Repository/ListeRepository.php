<?php

namespace App\Repository;

use App\Entity\Liste;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Liste>
 *
 * @method Liste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Liste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Liste[]    findAll()
 * @method Liste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Liste::class);
    }

//    /**
//     * @return Liste[] Returns an array of Liste objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Liste
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * Récupérer les listes associées à un utilisateur
     *
     * @param User $user L'utilisateur pour lequel récupérer les listes
     * @return array
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('l')
            ->join('l.invites', 'u') // Supposons qu'il y ait une relation many-to-many entre Liste et User
            ->where('u = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
