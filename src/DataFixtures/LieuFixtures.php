<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use App\Entity\Ville;
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


        $villesMap = [];
        foreach ($villes as $ville) {
            $villesMap[$ville->getNom()] = $ville;
        }

        $lieu = new Lieu();
        $lieu
            ->setNom('Karting')
            ->setRue('Rue du moteur')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Loheac']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Soccer')
            ->setRue('Rue du five')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['La Mezière']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Visite du Mont Saint Michel')
            ->setRue('Rue du Mont')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Le Mont Saint Michel']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Barathon')
            ->setRue('Rue de la Soif')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Rennes']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Piscine')
            ->setRue('Rue Slipman')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Chartres de Bretagne']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Match Equipe de France')
            ->setRue('Rue st Denis')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Paris']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Match du SRFC')
            ->setRue('Route de Lorient')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Rennes']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Match FC Nantes')
            ->setRue('Rue la Beaujoire')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Nantes']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Restaurant Creperie')
            ->setRue('Rue de la crepe')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Bruz']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('WindSurfing')
            ->setRue('Rue du surf')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Lorient']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Char à voile')
            ->setRue('Rue de la voile')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['St Malo']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Jetski')
            ->setRue('Rue du jetski')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['St Nazaire']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Oceanopolis')
            ->setRue('Rue des animaux')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Brest']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Kayak')
            ->setRue('Rue du Canoé')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Cesson Sevigne']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Paintball')
            ->setRue('rue du shoot')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['La Mezière']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Escape game')
            ->setRue('Rue de Tarkov')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['Rennes']);
        $manager->persist($lieu);

        $lieu = new Lieu();
        $lieu
            ->setNom('Cinema')
            ->setRue('Rue du film')
            ->setLatitude($faker->latitude)
            ->setLongitude($faker->longitude)
            ->setVille($villesMap['La Mezière']);
        $manager->persist($lieu);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VilleFixtures::class,
        ];
    }

}