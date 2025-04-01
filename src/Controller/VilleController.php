<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use App\Repository\LieuRepository;

use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VilleController extends AbstractController
{
    #[Route('/ville/create', name: 'ville_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //Création de l'entité vide
        $ville = new Ville();

        $villeForm = $this->createForm(VilleType::class, $ville);
        //Récupère les données du formulaire et on les injecte dans notre $sortie.
        $villeForm->handleRequest($request);
        //On vérifie si le formulaire a été soumis et que les données soumises sont valides.
        if ($villeForm->isSubmitted() && $villeForm->isValid()) {
            $em->persist($ville);
            $em->flush();
            //Affiche un message à l'utilisateur sur la prochaine page.
            $this->addFlash('success', 'Votre ville a bien été ajouté !');
            //Redirige vers la liste des lieux
            return $this->redirectToRoute('ville_list', ['id' => $ville->getId()]);
        }
        //Affiche le formulaire
        return $this->render('ville/creation.html.twig', ["villeForm" => $villeForm]);
    }

    #[Route('/ville/list', name: 'ville_list', methods: ['GET'])]
    public function villelist(VilleRepository $villeRepository
    ): Response
    {
        $villes = $villeRepository->findAll();

        return $this->render('ville/list.html.twig', ['villes' => $villes]);
    }

}
