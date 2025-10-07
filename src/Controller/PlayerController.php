<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\Review;
use App\Form\AvisType;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/player')]
final class PlayerController extends AbstractController
{
    #[Route(name: 'app_player_index', methods: ['GET'])]
    public function index(PlayerRepository $playerRepository): Response
    {
        return $this->render('player/index.html.twig', [
            'players' => $playerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_player_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $player = new Player();
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($player);
            $entityManager->flush();

            return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('player/new.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_player_show', methods: ['GET'])]
    public function show(Player $player): Response
    {
        // collect reviews for this player
        $reviews = $player->getDesAvis()->toArray();

        // compute average rating if there are reviews
        $average = null;
        if (count($reviews) > 0) {
            $sum = 0;
            foreach ($reviews as $r) {
                $sum += (float) $r->getRating();
            }
            $average = round($sum / count($reviews), 2);
        }

        // if the user is logged in and hasn't already left a review, create the form view
        $formView = null;
        if ($this->getUser()) {
            $user = $this->getUser();
            $already = false;
            foreach ($reviews as $r) {
                if ($r->getUnUtilisateur() && $r->getUnUtilisateur()->getId() === $user->getId()) {
                    $already = true;
                    break;
                }
            }

            if (!$already) {
                $form = $this->createForm(AvisType::class, new Review());
                $formView = $form->createView();
            }
        }

        return $this->render('player/show.html.twig', [
            'player' => $player,
            'reviews' => $reviews,
            'average' => $average,
            'form' => $formView,
        ]);
    }

    #[Route('/{id}/review', name: 'app_player_review', methods: ['POST'])]
    public function review(Player $player, Request $request, EntityManagerInterface $entityManager): Response
    {
        // only users with ROLE_USER or ROLE_ADMIN can post reviews
        if (!($this->isGranted('ROLE_USER') || $this->isGranted('ROLE_ADMIN'))) {
            $this->addFlash('error', 'Vous devez être connecté en tant qu\'utilisateur pour laisser un avis.');
            return $this->redirectToRoute('app_login');
        }

        $review = new Review();
        $form = $this->createForm(AvisType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ensure the user hasn't already left a review for this player
            $user = $this->getUser();
            $already = false;
            foreach ($player->getDesAvis() as $existing) {
                if ($existing->getUnUtilisateur() && $existing->getUnUtilisateur()->getId() === $user->getId()) {
                    $already = true;
                    break;
                }
            }

            if ($already) {
                $this->addFlash('warning', 'Vous avez déjà laissé un avis pour ce joueur.');
                return $this->redirectToRoute('app_player_show', ['id' => $player->getId()]);
            }

            // attach current user and player and timestamp
            $review->setUnUtilisateur($user);
            $review->setUnJoueur($player);
            $review->setCreatedAt(new \DateTime());

            $entityManager->persist($review);
            $entityManager->flush();

            $this->addFlash('success', 'Votre avis a bien été enregistré.');
            return $this->redirectToRoute('app_player_show', ['id' => $player->getId()]);
        }

        // on invalid form submission, re-render show with errors
        $reviews = $player->getDesAvis()->toArray();
        $average = null;
        if (count($reviews) > 0) {
            $sum = 0;
            foreach ($reviews as $r) {
                $sum += (float) $r->getRating();
            }
            $average = round($sum / count($reviews), 2);
        }

        return $this->render('player/show.html.twig', [
            'player' => $player,
            'reviews' => $reviews,
            'average' => $average,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_player_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('player/edit.html.twig', [
            'player' => $player,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_player_delete', methods: ['POST'])]
    public function delete(Request $request, Player $player, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$player->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($player);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_player_index', [], Response::HTTP_SEE_OTHER);
    }
}
