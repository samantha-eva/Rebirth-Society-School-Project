<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PackRepository;
use App\Repository\VideoRepository;
final class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'catalogue')]
    public function index(PackRepository $packRepo, VideoRepository $videoRepo): Response
    {
        // Récupérer tous les packs
        $packs = $packRepo->findAllPacks();

        // Récupérer toutes les vidéos (cours individuels)
        $videos = $videoRepo->findAllVideos();

        return $this->render('catalogue/index.html.twig', [
            'packs' => $packs,
            'videos' => $videos,
        ]);
    }
}
