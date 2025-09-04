<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PackRepository;
use App\Entity\Pack;

final class PackController extends AbstractController
{
 
    #[Route('/pack/{id}', name: 'pack_detail')]
    public function show(Pack $pack): Response
    {
        // $pack sera automatiquement injecté par Symfony grâce à l'ID
        return $this->render('pack/detail.html.twig', [
            'pack' => $pack,
        ]);
    }
}
