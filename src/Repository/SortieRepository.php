<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function rechercheSorties($filters, $user)
    {
        $qb = $this->getEntityManager()->getRepository(Sortie::class)->createQueryBuilder('sortie')
            ->leftJoin('sortie.Site', 'site')
            ->leftJoin('sortie.Organisateur', 'organisateur')
            ->leftJoin('sortie.Participants', 'participants');

        // Filtrage par site
        if (!empty($filters['site'])) {
            $qb->andWhere('sortie.Site = :site')
                ->setParameter('site', $filters['site']);
        }

        // Filtrage par nom
        if (!empty($filters['nom'])) {
            $qb->andWhere('sortie.nom LIKE :nom')
                ->setParameter('nom', '%' . $filters['nom'] . '%');
        }

        // Filtrage par date
        if (!empty($filters['dateDebut']) && !empty($filters['dateFin'])) {
            $qb->andWhere('sortie.dateHeureDebut BETWEEN :dateDebut AND :dateFin')
                ->setParameter('dateDebut', $filters['dateDebut'])
                ->setParameter('dateFin', $filters['dateFin']);
        }

        // Sorties dont l'utilisateur est organisateur
        if (!empty($filters['organisateur'])) {
            $qb->andWhere('organisateur = :user')
                ->setParameter('user', $user);
        }

        // Sorties auxquelles l'utilisateur est inscrit
        if (!empty($filters['inscrit'])) {
            $qb->andWhere(':user MEMBER OF sortie.Participants')
                ->setParameter('user', $user);
        }

        // Sorties auxquelles l'utilisateur n'est pas inscrit
        if (!empty($filters['nonInscrit'])) {
            $qb->andWhere(':user NOT MEMBER OF sortie.Participants')
                ->setParameter('user', $user);
        }

        // Sorties passées
        if (!empty($filters['sortiesPassees'])) {
            $qb->andWhere('sortie.dateHeureDebut < :now')
                ->setParameter('now', new \DateTime());
        }

        return $qb->orderBy('sortie.dateHeureDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
