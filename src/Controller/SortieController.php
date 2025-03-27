<?php

namespace App\Controller;


use App\Entity\Participant;
use App\Entity\Sortie;
use App\Form\SearchType;
use App\Form\SortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SortieController extends AbstractController
{
    #[Route('/sorties', name: 'sortie_list', methods: ['GET'])]
    public function list(Request $request, SortieRepository $sortieRepository
    ): Response
    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        $sorties = [];
        if (!($searchForm->isEmpty())) {
            $filters = $searchForm->getData();
            dump($filters);
            $sorties = $sortieRepository->rechercheSorties($filters, $user);
            dump($sorties);
        } else {
            // Par défaut, charger toutes les sorties à venir
            $sorties = $sortieRepository->findAll();
        }

        return $this->render('sortie/list.html.twig', [
            'searchForm' => $searchForm->createView(),
            'sorties' => $sorties
        ]);



//        $sorties = $sortieRepository
//            ->findAll();
//        return $this->render('sortie/list.html.twig', ["sorties" => $sorties]);
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

    #[Route('/sorties/archives', name: 'sortie_archives', methods: ['GET'])]
    public function archive(Request $request, SortieRepository $sortieRepository
    ): Response
    {
        $user = $this->getUser(); // Récupère l'utilisateur connecté
        $searchForm = $this->createForm(SearchType::class);
        $searchForm->handleRequest($request);

        $sorties = [];
        if (!($searchForm->isEmpty())) {
            $filters = $searchForm->getData();
            dump($filters);
            $sorties = $sortieRepository->rechercheSorties($filters, $user)->findSortiesFromLastMonth();
            dump($sorties);
        } else {
            // Par défaut, charger toutes les sorties à venir
            $sorties = $sortieRepository->findSortiesFromLastMonth();
        }

        return $this->render('sortie/list.html.twig', [
            'searchForm' => $searchForm->createView(),
            'sorties' => $sorties
        ]);

    }


    #[Route('/sorties/create', name: 'sortie_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        //Création de l'entité vide
        $sortie = new Sortie();
        $sortie->setOrganisateur($this->getUser());
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

        if(!($sortie->getOrganisateur() === $this->getUser())){
            throw $this->createAccessDeniedException("Seul l'organisateur peut modifier la sortie");
        }

        $sortieForm = $this->createForm(SortieType::class, $sortie);
        $sortieForm->handleRequest($request);
        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            $em->flush();
            $this->addFlash('success', 'La sortie a bien été mise à jour');
            return $this->redirectToRoute('sortie_detail', ['id' => $sortie->getId()]);
        }
        return $this->render('sortie/creation.html.twig', ["sortieForm" => $sortieForm]);
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
        if(!($sortie->getOrganisateur() === $this->getUser())){
            throw $this->createAccessDeniedException("Seul l'organisateur de la sortie peut supprimer ladite sortie");
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

    #[Route('/sorties/{id}/inscription', name: 'sortie_inscription', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
//    #[IsGranted('WISH_EDIT', 'sortie')]
    public function inscriptionSortie(Sortie $sortie, Request $request, EntityManagerInterface $em): Response
    {

        if (!$sortie) {
            throw $this->createNotFoundException('Pardon, mais cette sortie n\'existe pas !' );
        }

        $sortie = $em->getRepository(Sortie::class)->find($sortie->getId());
        if ($sortie->getParticipants()->contains($this->getUser())) {
            $this->addFlash('fail', 'Tu es déjà inscris !');
        }
        elseif ($this->getUser() instanceof Participant and $sortie->getNbInscriptionMax() > $sortie->getParticipants()->count()) {

            $sortie->addParticipant($this->getUser());
            $em->flush();

            $this->addFlash('success', 'Your sortie has been updated!');

            return $this->redirectToRoute('sortie_detail', ['id' => $sortie->getId()]);

        }

        return $this->redirectToRoute('sortie_detail', ['id' => $sortie->getId()]);
    }

    #[Route('/sorties/{id}/desinscription', name: 'desinscription', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
//    #[IsGranted('WISH_EDIT', 'sortie')]
    public function desinscription(Sortie $sortie, Request $request, EntityManagerInterface $em): Response
    {

        if (!$sortie) {
            throw $this->createNotFoundException('Pardon, mais cette sortie n\'existe pas !' );
        }

        $sortie = $em->getRepository(Sortie::class)->find($sortie->getId());
        if ($sortie->getParticipants()->contains($this->getUser())) {
            $sortie->removeParticipant($this->getUser());
            $em->flush();
            $this->addFlash('success', 'Tu as été desincris de cette sortie!');
        }

        return $this->redirectToRoute('sortie_detail', ['id' => $sortie->getId()]);
    }

    #[Route('/sorties/{id}/annulation', name: 'annulation', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
//    #[IsGranted('WISH_EDIT', 'sortie')]
    public function annulation(Sortie $sortie, Request $request, EntityManagerInterface $em): Response
    {

        if (!$sortie) {
            throw $this->createNotFoundException('Pardon, mais cette sortie n\'existe pas !' );
        }

        $sortie = $em->getRepository(Sortie::class)->find($sortie->getId());
        if ($sortie->getOrganisateur() == ($this->getUser())) {
            $em->remove($sortie, true);
            $em->flush();
            $this->addFlash('success', 'Cette sortie a été annulée !');
        }

        return $this->redirectToRoute('sortie_detail', ['id' => $sortie->getId()]);
    }
}
