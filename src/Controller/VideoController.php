<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Video;

final class VideoController extends AbstractController
{
    #[Route('/video/{id}', name: 'video_detail')]
    public function show(Video $video): Response
    {
        // $pack sera automatiquement injecté par Symfony grâce à l'ID
        return $this->render('video/detail.html.twig', [
            'video' => $video,
        ]);
    }
}
