<?php

namespace App\Controller;

use App\Entity\BoardGame;
use App\Entity\Play;
use App\Service\HashCodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PlayController extends AbstractController
{
    /**
     * @Route("/api/play/{id}", name="add_play", methods={"POST"})
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
            return $this->json([
                'error' => 'The game not found'
            ], 404);
        }

        $entityManager = $this->getDoctrine()->getManager();

        // Simplest security
        $code = $request->get('code', '');
        if (!$code || $code !== (new HashCodeService($entityManager))->getCode()) {
            return $this->json([
                'error' => 'Unauthorized access'
            ], 401);
        }

        $play = new Play();
        $play->setBoardGame($game);

        $entityManager->persist($play);
        $entityManager->flush();

        return $this->json([
            'message' => 'Play saved',
        ]);
    }
}
