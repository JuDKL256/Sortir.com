<?php

// src/Controller/ImportController.php
namespace App\Controller;

use App\Entity\Participant;
use App\Form\ImportCsvType;
use App\Services\CsvImportService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ImportController extends AbstractController
{

      #[Route('/import-participants', name:'import_participants')]

    public function importParticipants(Request $request, CsvImportService $csvImportService,UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $em): Response
      {

          $form = $this->createForm(ImportCsvType::class);
          $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) {
              $csvFile = $form->get('csvFile')->getData();
              $site = $form->get('site')->getData();
              $password = $form->get('password')->getData();

              $importCount = $csvImportService->processCsvImport($csvFile,$site,$password);

              $this->addFlash('success', 'Import effectué avec '.$importCount.' participants');

              return $this->redirectToRoute('import_participants');

          }
          return $this->render('registration/import_participants.html.twig', [
              'form' => $form->createView(),
          ]);
                }
    private function processData(mixed $csvFile, mixed $site)
    {
    }
}