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
            // Récupérer tous les packs et vidéos
            $packs = $packRepo->findAllPacks();
            $videos = $videoRepo->findAllVideos();

            // Préparer une liste mixte
            $elements = [];

            // Ajouter les packs
            foreach ($packs as $pack) {
                $elements[] = [
                    'type' => 'pack',             // pour identifier le type
                    'name' => $pack->getName(),
                    'videos' => $pack->getVideos(), // nombre de vidéos
                ];
            }

            // Ajouter les vidéos individuelles
            foreach ($videos as $video) {
                $elements[] = [
                    'type' => 'video',            // pour identifier le type
                    'name' => $video->getName(),
                    'categorie' => $video->getCategorie(), // objet catégorie
                ];
            }

            // Envoyer la liste mixte à la vue
            return $this->render('catalogue/index.html.twig', [
                'elements' => $elements,
            ]);
        }
    }
