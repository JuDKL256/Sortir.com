<?php
namespace App\DataFixtures;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Retrieve related entities
        $sites = $manager->getRepository(Site::class)->findAll();
        $lieux = $manager->getRepository(Lieu::class)->findAll();
        $etats = $manager->getRepository(Etat::class)->findAll();
        $participants = $manager->getRepository(Participant::class)->findAll();

        // Create a map for lieux for easy access by name
        $lieuxMap = [];
        foreach ($lieux as $lieu) {
            $lieuxMap[$lieu->getNom()] = $lieu;
        }
        $etatsMap=[];
        foreach ($etats as $etat){
            $etatsMap[$etat->getLibelle()]=$etat;
        }

        $etatsMap = [];
        foreach ($etats as $etat) {
            $etatsMap[$etat->getLibelle()] = $etat;
        }

        $sortie = new Sortie();
        $sortie
            ->setNom('Après midi Karting')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Petite sortie de Karting avec tous ceux qui le veulent, on va bien rigoler')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Karting'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('Sortie au cinema')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Le film "Un petit truc en plus" vient de sortir et on vous propose de vous joindre à nous pour aller le voir')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Cinema'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('Barathon rue de la soif')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('On fête les beaux jours en organisant un barathon au cœur de la ville')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Barathon'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('Le plongeon du saumon')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Si un midi vous voulez vous détendre et vous faire plaisir, enfilez votre plus beau slip et venez piquer une tête')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Piscine'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('Soccer all Stars')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Un match de foot pour tous les amateurs de foot, venez jouer avec nous !')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Soccer'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('Le Mont Saint Michel')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Une visite du Mont Saint Michel pour tous ceux qui le veulent !')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Visite du Mont Saint Michel'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('France vs Argentina')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Un match de foot pour voir la France prendre sa revanche sur l\'Argentine !')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Match Equipe de France'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('Rennes-Paris')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Le Stade Rennais rencontre le PSG pour cette dernière journée de championnat, prenez vos places !!!')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Match du SRFC'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('FC Nantes vs Lyon')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Nantes et Lyon se rencontrent pour cette dernière partie de championnat, venez supporter les canaris avec nous !')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Match FC Nantes'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $sortie = new Sortie();
        $sortie
            ->setNom('Journée pour jouer avec le vent')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('On passe la journée à Lorient, et on fait une activité windsurfing !')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['WindSurfing'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);


        $sortie = new Sortie();
        $sortie
            ->setNom('Ca pagaie !')
            ->setDateHeureDebut($faker->dateTimeBetween('+1 days', '+2 months'))
            ->setDuree($faker->numberBetween(30, 240))
            ->setDateLimiteInscription($faker->dateTimeBetween('now', '+1 month'))
            ->setNbInscriptionMax($faker->numberBetween(5, 50))
            ->setInfosSortie('Sur la Vilaine, on propose une journée pour découvrir le kayak')
            ->setOrganisateur($faker->randomElement($participants))
            ->setLieu($lieuxMap['Kayak'])
            ->setEtat($etatsMap['Créée'])
            ->setSite($faker->randomElement($sites));
        $manager->persist($sortie);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            LieuFixtures::class,
            EtatFixtures::class,
            ParticipantFixtures::class,
            SiteFixtures::class,
        ];
    }
}
