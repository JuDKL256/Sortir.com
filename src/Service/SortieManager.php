<?php

namespace App\Service;

use App\Entity\Etat;
use App\Entity\Sortie;
use App\Entity\MotifAnnulation;
use Doctrine\ORM\EntityManagerInterface;

class SortieManager
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function annulerSortie(Sortie $sortie, MotifAnnulation $motif): void
    {
        $etatAnnulee = $this->em->getRepository(Etat::class)
            ->findOneBy(['libelle' => 'Annulée']);

        $sortie->setEtat($etatAnnulee)
            ->setInfosSortie("Annulation : " . $motif->getMotif());

        $this->em->persist($motif);
        $this->em->flush();
    }

    public function creerSortie(Sortie $sortie): void
    {
        $etatCree = $this->em->getRepository(Etat::class)
            ->findOneBy(['libelle' => 'Créée']);

        $sortie->setEtat($etatCree);
        $this->em->persist($sortie);
        $this->em->flush();
    }

    // Dans src/Service/SortieManager.php
    public function updateEtatSortie(Sortie $sortie): void
    {
        $timezone = new \DateTimeZone('Europe/Paris');
        $now = new \DateTime('now', $timezone);

        // Convertit les dates stockées en UTC vers Paris
        $dateDebut = (clone $sortie->getDateHeureDebut())->setTimezone($timezone)->sub(new \DateInterval('PT4H'));
        $dateFin = (clone $dateDebut)->add(new \DateInterval('PT'.$sortie->getDuree().'S')); // Secondes

//        dd([
//            'nom sortie' => $sortie->getNom(),
//            'duree' => $sortie->getDuree(),
//            'now' => $now,
//            'dateDebut' => $dateDebut,
//            'dateFin' => $dateFin,
//            'condition' => ($dateDebut <= $now && $now <= $dateFin)
//        ]);

        // 1. Ne pas modifier les sorties annulées
        if ($sortie->getEtat()->getLibelle() === 'Annulée') {
            return;
        }



        // 2. Vérification stricte "Activité en cours" (prioritaire)
        if ($dateDebut <= $now && $now <= $dateFin) {
//            dd($dateFin);
            $this->changerEtat($sortie, 'Activité en cours');
            return; // On stoppe ici pour garantir l'état
        }

        // 3. Gestion des autres états (seulement si pas en cours)
        if ($dateFin < $now) {
            $nouvelEtat = 'Passée';
        } elseif ($sortie->getDateLimiteInscription() < $now
            || $sortie->getParticipants()->count() >= $sortie->getNbInscriptionMax()) {
            $nouvelEtat = 'Clôturée';
        } else {
            $nouvelEtat = 'Ouverte';
        }

        // 4. Appliquer le changement si nécessaire
        if ($sortie->getEtat()->getLibelle() !== $nouvelEtat) {
            $this->changerEtat($sortie, $nouvelEtat);
        }
    }

    public function changerEtat(Sortie $sortie, string $nouvelEtat): void
    {
        $etat = $this->em->getRepository(Etat::class)
            ->findOneBy(['libelle' => $nouvelEtat]);

        if (!$etat) {
            throw new \RuntimeException("État '$nouvelEtat' non trouvé");
        }

        $sortie->setEtat($etat);
        $this->em->flush();
    }
}