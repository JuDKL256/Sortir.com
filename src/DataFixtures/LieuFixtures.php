<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $villes = $manager->getRepository(Ville::class)->findAll();

        $prefix = ["Le", "La", "Les", "Un", "Une"];

        $adjectives = [
            "Mystérieux", "Futuriste", "Élégant", "Lumineux", "Enchanté",
            "Épique", "Serein", "Vibrant", "Éclatant", "Magique",
            "Intrigant", "Radieux", "Énigmatique", "Captivant", "Éblouissant"
        ];

        $nouns = [
            "Refuge", "Sanctuaire", "Oasis", "Havre", "Paradis",
            "Espace", "Royaume", "Nexus", "Horizon", "Mirage",
            "Atelier", "Galerie", "Théâtre", "Salon", "Retraite"
        ];

        for ($i = 0; $i < 20; $i++) {
            $lieu = new Lieu();
            $fakename = $prefix[array_rand($prefix)] . " " . $adjectives[array_rand($adjectives)] . " " . $nouns[array_rand($nouns)];
            $lieu->setNom($fakename);
            $lieu->setRue($faker->streetName);
            $lieu->setLatitude($faker->latitude);
            $lieu->setLongitude($faker->longitude);
            $lieu->setVille($faker->randomElement($villes));
            $manager->persist($lieu);
        }
        $manager->flush();
    }

    public function getDependencies():
    array
    {
        return [
            VilleFixtures::class,
        ];
    }
}