<?php

namespace App\Controller;

use App\Entity\Point;
use App\Repository\PointRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PointRepository $pointRepository): JsonResponse
    {
        return $this->json($pointRepository->paginate());
    }

    #[Route('/point', name: 'app_point')]
    public function point(
        EntityManagerInterface $entityManager,
        Request $request,
        PointRepository $pointRepository
    ): JsonResponse {
        $payload = $request->getPayload()->all();
        $geometry = $payload['geometry'] ?? [];

        $coord = join( ' ', $geometry);
        $point = (new Point())->setGeometry("POINT($coord)");

        $entityManager->persist($point);
        $entityManager->flush();

        return $this->json($pointRepository->findAll());
    }
}
