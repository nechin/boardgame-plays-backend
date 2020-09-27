<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Entity\Play;
use Nechin\SmartHash\SmartHash;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayController extends AbstractController
{
    /**
     * @Route("/play/{id}", name="add_play", methods={"POST"})
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function add(Request $request, int $id): JsonResponse
    {
        $game = $this->getDoctrine()
            ->getRepository(BoardGame::class)
            ->find($id);

        if (!$game) {
            return $this->json('The game not found', 404);
        }

        // Simplest security
        $code = $request->get('code');
        if (!$code || $code !== SmartHash::hash($game->getName() . getenv('APP_SECRET'), 16)) {
            return $this->json('Unauthorized access', 401);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $play = new Play();
        $play->setBoardGame($game);

        $entityManager->persist($play);
        $entityManager->flush();

        return $this->json('Play saved');
    }
}
