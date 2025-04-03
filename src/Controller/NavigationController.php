<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Repository\SortieRepository;
use App\Service\SortieManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NavigationController extends AbstractController
{
    #[Route('/', name: 'app_acceuil')]
    public function accueil(SortieRepository $sortieRepository, SortieManager $sortieManager): Response
    {

        return $this->render('navigation/acceuil.html.twig');
    }


    #[Route('/about_us', name: 'app_about_us')]
    public function aboutUs(): Response
    {
       return $this->render('navigation/about_us.html.twig');
    }
}
