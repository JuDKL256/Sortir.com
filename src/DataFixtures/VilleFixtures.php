<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $ville = new Ville();
        $ville
            ->setNom('Rennes')
            ->setCodePostal('35000');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Loheac')
            ->setCodePostal('35550');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('La Mezière')
            ->setCodePostal('35520');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Chartres de Bretagne')
            ->setCodePostal('35131');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Bruz')
            ->setCodePostal('35047');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Cesson Sevigne')
            ->setCodePostal('35510');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Lorient')
            ->setCodePostal('56100');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Le Mont Saint Michel')
            ->setCodePostal('50170');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Nantes')
            ->setCodePostal('44000');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('St Malo')
            ->setCodePostal('35400');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Brest')
            ->setCodePostal('29200');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('St Nazaire')
            ->setCodePostal('44600');
        $manager->persist($ville);

        $ville = new Ville();
        $ville
            ->setNom('Paris')
            ->setCodePostal('75001');
        $manager->persist($ville);



        $manager->flush();
    }
}



