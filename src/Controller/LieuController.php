<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\LieuType;
use App\Repository\LieuRepository;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LieuController extends AbstractController
{
    #[Route('/lieu/create', name: 'lieu_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //Création de l'entité vide
        $lieu = new Lieu();

        $lieuForm = $this->createForm(LieuType::class, $lieu);
        //Récupère les données du formulaire et on les injecte dans notre $sortie.
        $lieuForm->handleRequest($request);
        //On vérifie si le formulaire a été soumis et que les données soumises sont valides.
        if ($lieuForm->isSubmitted() && $lieuForm->isValid()) {
            $em->persist($lieu);
            $em->flush();
            //Affiche un message à l'utilisateur sur la prochaine page.
            $this->addFlash('success', 'Votre Lieu a bien été ajouté !');
            //Redirige vers la liste des lieux
            return $this->redirectToRoute('lieu_list', ['id' => $lieu->getId()]);
        }
        //Affiche le formulaire
        return $this->render('lieu/creation.html.twig', ["lieuForm" => $lieuForm]);
    }

    #[Route('/lieu/list', name: 'lieu_list', methods: ['GET'])]
    public function lieulist(LieuRepository $lieuRepository
    ): Response
    {
        $lieux = $lieuRepository->findAll();
        return $this->render('lieu/list.html.twig', ["lieux" => $lieux]);
    }

}
