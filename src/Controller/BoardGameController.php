<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Repository\BoardGameRepository;
use App\Service\BoardGameService;
use App\Service\HashCodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class BoardGameController extends AbstractController
{
    /**
     * @Route("/api/games", name="board_game", methods={"GET"})
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $games = [];

        $gamesCollection = $this->getDoctrine()
            ->getRepository(BoardGame::class)
            ->getAllSortByName();

        if (count($gamesCollection)) {
            $gameService = new BoardGameService();
            foreach ($gamesCollection as $game) {
                $games[] = $gameService->getGameData($game);
            }
        }

        $entityManager = $this->getDoctrine()->getManager();

        return $this->json([
            'games' => $games,
            'code' => (new HashCodeService($entityManager))->getCode(),
        ], 200, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * @Route("/api/game/{id}", name="game_show", methods={"GET"})
     * @param int $id
     * @param BoardGameRepository $gameRepository
     * @return JsonResponse
     */
    public function show(int $id, BoardGameRepository $gameRepository): JsonResponse
    {
        $game = $gameRepository->find($id);

        if (!$game) {
            return $this->json([
                'error' => 'The game not found'
            ], 404);
        }

        return $this->json(
            (new BoardGameService())->getGameData($game)
        );
    }
}
