<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 30; $i++) {
            $ville = new Ville();
            $ville->setNom($faker->city);
            $ville->setCodePostal(str_pad(mt_rand(1000, 99999), 5, '0', STR_PAD_LEFT));
            $manager->persist($ville);
        }

        $manager->flush();
    }
}
