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
use Symfony\Component\Routing\Attribute\Route;

final class ParticipantController extends AbstractController
{
    #[Route('/profil', name: 'mon_profil',methods: ['GET','POST'])]
    public function index(EntityManagerInterface $entityManager,Request $request
    ): Response
    {
        // Récupérer le participant actuellement connecté
        $participant = $this->getUser();

        // Créer le formulaire
        $form = $this->createForm(RegistrationFormType::class, $participant);

        // Traiter le formulaire lorsqu'il est soumis
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications dans la base de données
            $entityManager->persist($participant);
            $entityManager->flush();

            // Rediriger ou afficher un message de succès
            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('mon_profil');
        }else {
            $this->addFlash('error','erreur dans la maj du profil');
            }

        // Afficher le formulaire
        return $this->render('participant/monProfil.html.twig', [
            'participant' => $participant,
            'form' => $form->createView(),
        ]);
    }
}
