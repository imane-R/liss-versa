<?php

namespace App\Controller;

use App\Repository\ProduitsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TraitementsController extends AbstractController
{
    #[Route('/traitements', name: 'app_traitements')]
    public function showAllProducts(ProduitsRepository $repo): Response
    {
        $traitements = $repo->findAll();
        return $this->render('traitements/index.html.twig', [
            'traitements' => $traitements,
        ]);
    }
}
