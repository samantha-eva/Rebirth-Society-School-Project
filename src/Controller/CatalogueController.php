<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PackRepository;
use App\Repository\VideoRepository;
final class CatalogueController extends AbstractController
{

   // src/Controller/CatalogueController.php

#[Route('/catalogue/{page<\d+>?1}', name: 'catalogue')]
public function index(
    PackRepository $packRepo,
    VideoRepository $videoRepo,
    int $page = 1
): Response {
    $limit = 12; // éléments par page

    // Récupérer tous les packs et vidéos
    $packs = $packRepo->findAll();
    $videos = $videoRepo->findAll();

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

    // Pagination manuelle
    $total = count($elements);
    $pages = ceil($total / $limit);
    $elements = array_slice($elements, ($page - 1) * $limit, $limit);

    return $this->render('catalogue/index.html.twig', [
        'elements' => $elements,
        'page' => $page,
        'pages' => $pages,
    ]);
}


}

