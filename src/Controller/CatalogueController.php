<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PackRepository;
use App\Repository\VideoRepository;

final class CatalogueController extends AbstractController
{
    #[Route('/catalogue/{page<\d+>?1}', name: 'catalogue')]
    public function index(
        PackRepository $packRepo,
        VideoRepository $videoRepo,
        Request $request,
        int $page = 1
    ): Response {
        $limit = 8; // éléments par page
        $filter = $request->query->get('filter', 'all'); // "all" par défaut

        // Récupérer tous les packs et vidéos
        $packs = $packRepo->findAllPacks();
        $videos = $videoRepo->findAllVideos();

        // Liste mixte
        $elements = [];
        foreach ($packs as $pack) {
            $elements[] = [
                'type' => 'pack',
                'nom' => $pack->getName(),
                'videos' => $pack->getVideos(),
                'price' => $pack->getPrice(),
                'image' => $pack->getImage(),
            ];
        }
        foreach ($videos as $video) {
            $elements[] = [
                'type' => 'video',
                'nom' => $video->getName(),
                'categorie' => $video->getCategorie(),
                'price' => $video->getPrice(),
                'image' => $video->getImage(),
            ];
        }

        // Application du filtre
        if ($filter !== 'all') {
            $elements = array_filter($elements, function ($el) use ($filter) {
                if ($el['type'] === 'video' && $el['categorie']) {
                    return strtolower($el['categorie']->getName()) === strtolower($filter);
                }
                return false; // les packs ne sont pas filtrés par catégorie
            });
        }

        // Pagination
        $total = count($elements);
        $pages = max(1, ceil($total / $limit));
        $elements = array_slice($elements, ($page - 1) * $limit, $limit);

        return $this->render('catalogue/index.html.twig', [
            'elements' => $elements,
            'page' => $page,
            'pages' => $pages,
            'filter' => $filter,
        ]);
    }
}
