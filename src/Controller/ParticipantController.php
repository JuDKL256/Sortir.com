<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_USER')]
final class ParticipantController extends AbstractController
{
    #[Route('/profil', name: 'mon_profil', methods: ['GET', 'POST'])]
    public function show(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $participant = $this->getUser();

        if (!$participant) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $editMode = $request->query->get('edit') === '1';

        // Création du formulaire de modification du profil
        $form = $this->createForm(RegistrationFormType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Vérifiez si un nouveau mot de passe a été soumis
            $newPassword = $form->get('plainPassword')->getData();
            if ($newPassword) {
                // Hash et définissez le nouveau mot de passe
                $hashedPassword = $passwordHasher->hashPassword($participant, $newPassword);
                $participant->setPassword($hashedPassword);
            }

            $entityManager->persist($participant);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès');

            return $this->redirectToRoute('mon_profil');
        }

        return $this->render('participant/monProfil.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
            'editMode' => $editMode,
        ]);
    }
}


