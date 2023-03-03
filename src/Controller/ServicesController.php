<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServicesController extends AbstractController
{
    public function showAllService(ServiceRepository $repo): Response
    {
        $services = $repo->findAll();
        // dd($services);
        return $this->render("fragments/_services.html.twig", [
            'services' =>  $services
        ]);
    }
}
