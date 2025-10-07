<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class PageAccueilController extends AbstractController
{
    #[Route('/', name: 'app_page_accueil')]
    public function index(PlayerRepository $playerRepo): Response
    {
        // Récupère tous les joueurs
        $players = $playerRepo->findAll();

        return $this->render('page_accueil/index.html.twig', [
            'players' => $players,
        ]);
    }
}
