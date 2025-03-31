<?php
// src/Service/CsvImportService.php
namespace App\Services;

use App\Entity\Participant;
use App\Entity\Site;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CsvImportService
{
    private $em;
    private $passwordHasher;

    public function __construct(EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher)
    {
        $this->em = $em;
        $this->passwordHasher = $passwordHasher;
    }

    public function processCsvImport($csvFile, Site $site = null, string $password = null)
    {
        if (!$site || !$password) {
            throw new \InvalidArgumentException('Le site et le mot de passe sont obligatoires');
        }

        $handle = fopen($csvFile->getPathname(), 'r');

        // Lire les en-têtes (optionnel, si vous avez besoin de les vérifier)
        $headers = fgetcsv($handle, 1000, ';');

        $importCount = 0;

        while (($data = fgetcsv($handle, 1000, ';')) !== false) {
            if (count($data) === 5) {
                $participant = new Participant();

                $participant->setUsername($data[0]);
                $participant->setPrenom($data[2]);
                $participant->setNom($data[1]);
                $participant->setTelephone($data[4]);
                $participant->setMail($data[3]);
                $participant->setActif(true);

                // Définir le site et le mot de passe
                $participant->setSite($site);
                $participant->setPassword(
                    $this->passwordHasher->hashPassword($participant, $password)
                );

                $this->em->persist($participant);
                $importCount++;
            } else {
                // Gérez le cas où la ligne n'a pas le bon nombre de colonnes
                error_log("Erreur : La ligne suivante n'a pas le bon nombre de colonnes : " . implode(';', $data));
            }
        }

        $this->em->flush();
        fclose($handle);

        return $importCount;
    }
}