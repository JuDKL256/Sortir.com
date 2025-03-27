<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\RegistrationFormType;
use App\Repository\ParticipantRepository;
use App\Services\Uploader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    public function show(
        Request                     $request,
        EntityManagerInterface      $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        Uploader                    $uploader
    ): Response
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
            /**
             * @var UploadedFile|null $photoDeProfil
             */
            $photoDeProfil = $form->get('photoDeProfil')->getData();

            if ($photoDeProfil instanceof UploadedFile) {
                $participant->setPhotoProfile(
                    $uploader->save($photoDeProfil, $participant->getId(), $this->getParameter('photoDeProfil_dir'))
                );
            }

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

    #[Route('/profil/{id}', name: 'profil_utilisateur', methods: ['GET'])]
    public function showUserProfile(Participant $participant): Response
    {
        return $this->render('participant/profil.html.twig', [
            'participant' => $participant,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/list_users', name: 'list_users', methods: ['GET'])]
    public function listUsers(ParticipantRepository $participantRepository): Response
    {
        $users = $participantRepository->findAll();
        return $this->render('Admin/listUsers.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/toggle-status/{id}', name: "toggle_status", methods: ['GET', 'POST'])]
    public function toggleStatus(Participant $participant, EntityManagerInterface $entityManager): RedirectResponse
    {
        $participant->setActif(!$participant->isActif());

        $entityManager->persist($participant);
        $entityManager->flush();

        // Redirige vers la page de profil ou une autre page appropriée
        return $this->redirectToRoute('profil_utilisateur', ['id' => $participant->getId()]);
    }

    #[Route('/delete/{id}', name:'delete',requirements: ['id'=>'\d+'],methods: ['GET','POST'])]
    public function delete(int $id,Participant $participant,
                           EntityManagerInterface $entityManager,
                            ParticipantRepository $participantRepository,
    ):Response{

        $participant=$participantRepository->find($id);
          $entityManager->remove($participant);
//          $entityManager->persist($participant);
          $entityManager->flush();

        $this->addFlash('success', 'Profil supprimer avec succès');

        return $this->redirectToRoute('list_users');

    }

}





