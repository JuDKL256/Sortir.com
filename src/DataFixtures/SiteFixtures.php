<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SiteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Données des sites
        $sitesData = [
            ['nom' => 'Chartres de Bretagne'],
            ['nom' => 'Saint Herblain'],
            ['nom' => 'Niort'],
            ['nom' => 'Quimper'],
            ['nom' => 'La Roche sur Yon'],
        ];

        foreach ($sitesData as $siteData) {
            $site = new Site();
            $site->setNom($siteData['nom']);

            $manager->persist($site);
        }

        $manager->flush();

    }
}
