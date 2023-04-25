<?php

namespace App\Controller;

use App\Repository\MletpcRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MletpcController extends AbstractController
{
    #[Route('/mentionslegales}', name: 'app_mentionslegales')]
    public function mentionslegales(MletpcRepository $repo)
    {
        $mletpc = $repo->findAll();
        return $this->render('mletpc/mentionslegales.html.twig', [
            'mletpcs' =>  $mletpc
        ]);
    }
    #[Route('/politiquesdeconfidentialite}', name: 'app_politiquesdeconfidentialite')]
    public function politiquesdeconfidentialite(MletpcRepository $repo)
    {
        $mletpc = $repo->findAll();
        return $this->render('mletpc/politiquesdeconfidentialite.html.twig', [
            'mletpcs' =>  $mletpc
        ]);
    }
}
