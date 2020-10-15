<?php

namespace App\Controller;

use App\Entity\HashCode;
use App\Service\HashCodeService;
use Nechin\SmartHash\SmartHash;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HashCodeController extends AbstractController
{
    /**
     * @Route("/hash/ilwip", name="hash_code")
     * @param Request $request
     * @return JsonResponse
     */
    public function setHash(Request $request): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();

        (new HashCodeService($entityManager))->clearCodes();

        $play = new HashCode();
        $code = SmartHash::hash($request->getClientIp() . getenv('APP_SECRET'), 16);
        $play->setCode($code);

        $entityManager->persist($play);
        $entityManager->flush();

        return $this->json([
            'message' => 'Success',
        ]);
    }
}
