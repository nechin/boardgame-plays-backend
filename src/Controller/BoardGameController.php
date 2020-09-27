<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BoardGameController extends AbstractController
{
    /**
     * @Route("/games", name="board_game", methods={"GET"})
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $games = [];

        $gamesCollection = $this->getDoctrine()
            ->getRepository(BoardGame::class)
            ->findAll();

        foreach ($gamesCollection as $game) {
            $games[] = [
                'id' => $game->getId(),
                'name' => $game->getName(),
                'year' => $game->getYear()
            ];
        }

        return $this->json([
            'data' => $games,
        ]);
    }

    /**
     * @Route("/game/{id}", name="game_show", methods={"GET"})
     * @param int $id
     * @param BoardGameRepository $gameRepository
     * @return JsonResponse
     */
    public function show(int $id, BoardGameRepository $gameRepository): JsonResponse
    {
        $game = $gameRepository->find($id);

        return $this->json([
            'id' => $game->getId(),
            'name' => $game->getName(),
            'year' => $game->getYear()
        ]);
    }
}
