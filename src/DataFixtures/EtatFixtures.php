<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $libelles = ['Créée', 'Ouverte', 'Cloturée', 'Activitée en cours', 'Passée', 'Annulée'];

        foreach ($libelles as $libelle){

            $etat = new Etat();
            $etat->setLibelle($libelle);

            $manager->persist($etat);
        }
        $manager->flush();
    }
}