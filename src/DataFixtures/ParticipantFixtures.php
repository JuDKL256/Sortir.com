<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface
{


    public function __construct(private UserPasswordHasherInterface $userPasswordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $sites=$manager->getRepository(Site::class)->findAll();

        $participant = new Participant();
        $participant
                    ->setUsername('Jenna')
                    ->setNom('Jameson')
                    ->setPrenom('Jenna')
                    ->setmail('jenna@jenna.fr')
                    ->setTelephone('0670438190')
                    ->setPassword(
                        $this->userPasswordHasher->hashPassword(
                            $participant,
                            '123456'
                        )
                    )
                    ->setSite($faker->randomElement($sites))
                    ->setActif('true');

        $manager->persist($participant);

        $participant = new Participant();
        $participant
            ->setUsername('Belobito')
            ->setNom('Ferrara')
            ->setPrenom('Manu')
            ->setmail('manu@manu.fr')
            ->setTelephone('0671438190')

            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Abella')
            ->setNom('Danger')
            ->setPrenom('Abella')
            ->setmail('abella@abella.fr')
            ->setTelephone('0606804050')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Mia ')
            ->setNom('Khalifa')
            ->setPrenom('Mia ')
            ->setmail('mia@mia .fr')
            ->setTelephone('0605040302')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Lisa ')
            ->setNom('Ann')
            ->setPrenom('Lisa ')
            ->setmail('lisa@lisa .fr')
            ->setTelephone('0605070809')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Elnino')
            ->setNom('Polla')
            ->setPrenom('Jordi')
            ->setmail('jordi@jordi.fr')
            ->setTelephone('0689784556')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Pierre')
            ->setNom('Moro')
            ->setPrenom('Pierre')
            ->setmail('pierre@pierre.fr')
            ->setTelephone('0670438190')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Katsuni')
            ->setNom('Tran')
            ->setPrenom('Céline')
            ->setmail('celine@celine.fr')
            ->setTelephone('0600112233')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Clara')
            ->setNom('Munos')
            ->setPrenom('Emmanuelle')
            ->setmail('clara@clara.fr')
            ->setTelephone('0699887744')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Siffredi')
            ->setNom('Tano')
            ->setPrenom('Rocco')
            ->setmail('rocco@rocco.fr')
            ->setTelephone('0622334455')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Mimie')
            ->setNom('Mathy')
            ->setPrenom('Mimie')
            ->setmail('mimie@mimie.fr')
            ->setTelephone('0644887733')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Nacho')
            ->setNom('Vidal')
            ->setPrenom('Nacho')
            ->setmail('nacho@nacho.fr')
            ->setTelephone('0666778822')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Liza')
            ->setNom('DelSierra')
            ->setPrenom('Liza')
            ->setmail('liza@liza.fr')
            ->setTelephone('0633557799')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Eva')
            ->setNom('Delage')
            ->setPrenom('Eva')
            ->setmail('eva@eva.fr')
            ->setTelephone('0686492571')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Tabatha')
            ->setNom('Cash')
            ->setPrenom('Tabatha')
            ->setmail('tabatha@tabatha.fr')
            ->setTelephone('0696857420')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Phil')
            ->setNom('Hollyday')
            ->setPrenom('Phil')
            ->setmail('phil@phil.fr')
            ->setTelephone('0613467985')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Nikita ')
            ->setNom('Belucci')
            ->setPrenom('Nikita')
            ->setmail('nikita@nikita.fr')
            ->setTelephone('0650408090')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Seb ')
            ->setNom('Barrio')
            ->setPrenom('Sebastian')
            ->setmail('seb@seb.fr')
            ->setTelephone('0612918462')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Tony')
            ->setNom('Carrera')
            ->setPrenom('Tony')
            ->setmail('tony@tony.fr')
            ->setTelephone('0643768910')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('little')
            ->setNom('Caprice')
            ->setPrenom('Little')
            ->setmail('little@little.fr')
            ->setTelephone('0623458980')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');
        $manager->persist($participant);


        $participant = new Participant();
        $participant
            ->setUsername('Bonnie')
            ->setNom('Rotten')
            ->setPrenom('Bonnie')
            ->setmail('bonnie@bonnie.fr')
            ->setTelephone('0678956245')
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $participant,
                    '123456'
                )
            )
            ->setSite($faker->randomElement($sites))
            ->setActif('true');

        $manager->persist($participant);
        $manager->flush();



    }

    public function getDependencies(): array
    {
        return [
            SiteFixtures::class,

        ];
    }
}
