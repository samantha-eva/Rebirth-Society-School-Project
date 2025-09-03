<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PackRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(PackRepository $packRepository): Response
    {

        $packs = $packRepository->findAllPacks();

            return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'packs' => $packs, // <-- on passe les packs à la vue
        ]);
    }



}
