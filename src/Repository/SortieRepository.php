<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Models\SearchForm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\SecurityBundle\Security;


class SortieRepository extends ServiceEntityRepository
{
    private Security $security;

    public function __construct(ManagerRegistry $registry, Security $security)
    {
        parent::__construct($registry, Sortie::class);
        $this->security = $security;
    }

    public function rechercheSorties(SearchForm $searchForm)
    {
        $user = $this->security->getUser();

        $qb = $this->getEntityManager()->getRepository(Sortie::class)->createQueryBuilder('sortie')
            ->leftJoin('sortie.Site', 'site')
            ->leftJoin('sortie.Organisateur', 'organisateur')
            ->leftJoin('sortie.Participants', 'participants');

        // Ajout d'une condition pour n'afficher que les sorties non commencées par défaut
        $qb->andWhere('sortie.dateHeureDebut > :now')
            ->setParameter('now', new \DateTime());

        // Filtrage par site
        if ($searchForm->getSite()) {
            $qb->andWhere('sortie.Site = :site')
                ->setParameter('site', $searchForm->getSite());
        }

        // Filtrage par nom
        if ($searchForm->getNom()) {
            $qb->andWhere('sortie.nom LIKE :nom OR sortie.infosSortie LIKE :nom')
                ->setParameter('nom', '%' . $searchForm->getNom() . '%');
        }

        // Filtrage par date
        if ($searchForm->getDateDebut() && $searchForm->getDateFin()) {
            $qb->andWhere('sortie.dateHeureDebut BETWEEN :dateDebut AND :dateFin')
                ->setParameter('dateDebut', $searchForm->getDateDebut())
                ->setParameter('dateFin', $searchForm->getDateFin());
        }

        // Sorties dont l'utilisateur est organisateur
        if ($searchForm->isOrganisateur()) {
            $qb->andWhere('organisateur = :user')
                ->setParameter('user', $user);
        }

        // Sorties auxquelles l'utilisateur est inscrit
        if ($searchForm->isInscrit()) {
            $qb->andWhere(':user MEMBER OF sortie.Participants')
                ->setParameter('user', $user);
        }

        // Sorties auxquelles l'utilisateur n'est pas inscrit
        if ($searchForm->isNonInscrit()) {
            $qb->andWhere(':user NOT MEMBER OF sortie.Participants')
                ->setParameter('user', $user);
        }

        // Sorties passées (jusqu'à un mois après la date de début)
        if ($searchForm->isSortiesPassees()) {
            $oneMonthAgo = new \DateTime();
            $oneMonthAgo->sub(new \DateInterval('P1M'));

            $qb->andWhere('sortie.dateHeureDebut BETWEEN :oneMonthAgo AND :now')
                ->setParameter('oneMonthAgo', $oneMonthAgo)
                ->setParameter('now', new \DateTime());
        }

        return $qb->orderBy('sortie.dateHeureDebut', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findSortiesArchived()
    {
        $currentDate = new \DateTime();
        $currentDate->modify('-1 month');

        return $this->createQueryBuilder('s')
            ->where('s.dateHeureDebut >= :oneMonthAgo')
            ->setParameter('oneMonthAgo', $currentDate)
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
