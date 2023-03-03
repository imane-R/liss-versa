<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LissageController extends AbstractController
{
    #[Route('/lissage/{slug}', name: 'app_lissage')]
    public function showServiceBySlug($slug, ServiceRepository $repo): Response
    {
        $lissage = $repo->findOneBy(['slug' => $slug]);

        return $this->render('lissage/index.html.twig', [
            'lissage' => $lissage,
        ]);
    }
}
