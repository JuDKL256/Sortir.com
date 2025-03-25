<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SortieController extends AbstractController
{
    #[Route('/sorties', name: 'sortie_list', methods: ['GET'])]
    public function list(SortieRepository $sortieRepository
    ): Response
    {

        //Récupére les sortie publiés, du plus récent au plus ancien
        $sorties = $sortieRepository
            ->findAll();
        return $this->render('sortie/list.html.twig', ["sorties" => $sorties]);
    }

    #[Route('/sorties/{id}', name: 'sortie_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id, SortieRepository $sortieRepository
    ): Response
        // public function detail(Sortie $sortie, SortieRepository $sortieRepository
        //): Response
    {
        //Récupère ce sortie en fonction de l'id présent dans l'url
        $sortie = $sortieRepository
            ->find($id);
        if (!$sortie) {
            throw $this->createNotFoundException('This sortie do not exists! Sorry!');
        }
        return $this->render('sortie/detail.html.twig', ["sortie" => $sortie]);
    }

    #[Route('/sorties/create', name: 'sortie_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //Création de l'entité vide
        $sortie = new Sortie();
        $sortie->setOrganisateur($this->getUser()->getParticipant->getParticipantname());
        //Création du formulaire et association de l'entité vide.
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        //Récupère les données du formulaire et on les injecte dans notre $sortie.
        $sortieForm->handleRequest($request);
        //On vérifie si le formulaire a été soumis et que les données soumises sont valides.
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            //Hydrater les propriétés absentes du formulaire
//            $sortie->setIsPublished(true);
            //Sauvegarde dans la Bdd
            //ajout de la relation avec le user
            $em->persist($sortie);
            $em->flush();
            //Affiche un message à l'utilisateur sur la prochaine page.
            $this->addFlash('success', 'Your sortie has been created!');
            //Redirige vers la page de detail du sortie
            return $this->redirectToRoute('sortie_detail', ['id' => $sortie->getId()]);
        }
        //Affiche le formulaire
        return $this->render('sortie/creation.html.twig', ["sortieForm" => $sortieForm]);
    }


    #[Route('/sorties/{id}/update', name: 'sortie_update', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
//    #[IsGranted('WISH_EDIT', 'sortie')]
    public function update(Sortie $sortie, Request $request, EntityManagerInterface $em): Response
    {
        //Récupération de l'entité sortie  en fonction de son id.

        //s'il n'existe pas dans la bdd, on lance une erreur 404
        if (!$sortie) {
            throw $this->createNotFoundException('This sortie do not exists! Sorry!');
        }
        //Création du formulaire et association de l'entité .
        $sortieForm = $this->createForm(SortieType::class, $sortie);
        //Récupère les données du formulaire et on les injecte dans notre $sortie.
        $sortieForm->handleRequest($request);
        //On vérifie si le formulaire a été soumis et que les données soumises sont valides.
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            //Hydrater les propriétés absentes du formulaire
            $sortie->setDateUpdated(new \DateTimeImmutable());
            $sortie->getParticipant()->setParticipantname($censurator->censure(($sortie->getParticipant()->getParticipantname())));
            $sortie->setDescription($censurator->censure(($sortie->getDescription())));
            $sortie->setTitle($censurator->censure(($sortie->getTitle())));
            //Sauvegarde dans la Bdd
            $em->flush();
            //Affiche un message à l'utilisateur sur la prochaine page.
            $this->addFlash('success', 'Your sortie has been updated!');
            //Redirige vers la page de detail du sortie
            return $this->redirectToRoute('sortie_detail', ['id' => $sortie->getId()]);
        }
        //Affiche le formulaire
        return $this->render('sortie/create.html.twig', ["sortieForm" => $sortieForm]);
    }

    #[Route('/sorties/{id}/delete', name: 'sortie_delete', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function delete(int $id, SortieRepository $sortieRepository
        , Request $request, EntityManagerInterface $em): Response
    {
        $sortie = $sortieRepository
            ->find($id);
        //s'il n'existe pas dans la bdd, on lance une erreur 404
        if (!$sortie) {
            throw $this->createNotFoundException('This sortie do not exists! Sorry!');
        }

        //si je ne suis pas le proprio et que je ne suis pas admin alors je ne peux pas y accéder
//        if(!($sortie->getParticipant() === $this->getParticipant() || $this->isGranted("ROLE_ADMIN"))){
//            throw $this->createAccessDeniedException("Pas possible gamin !");
//        }
        if (!$this->isGranted('WISH_DELETE', $sortie)) {
            throw $this->createAccessDeniedException("Pas possible gamin !");
        }
        if ($this->isCsrfTokenValid('delete' . $sortie->getId(), $request->query->get('_token'))) {
            $em->remove($sortie, true);
            $em->flush();
            $this->addFlash('success', 'Your sortie has been deleted!');
        } else {
            $this->addFlash('danger', 'Your sortie cannot be deleted!');
        }
        return $this->redirectToRoute('sortie_list');
    }
}
