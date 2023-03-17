<?php

namespace App\Controller;

use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ServicesController extends AbstractController
{
    #[Route('/service/{slug}', name: 'app_service')]
    public function showServiceBySlug($slug, ServiceRepository $repo): Response
    {
        $service = $repo->findOneBy(['slug' => $slug]);

        return $this->render('service/index.html.twig', [
            'service' => $service,
        ]);
    }
    public function showAllServiceLissage(ServiceRepository $repo): Response
    {
        $services = $repo->findAll();
        return $this->render("fragments/_servicesCategorieLissage.html.twig", [
            'services' =>  $services
        ]);
    }
    public function showAllServiceSion(ServiceRepository $repo): Response
    {
        $services = $repo->findAll();

        return $this->render("fragments/_servicesCategorieSion.html.twig", [
            'services' =>  $services
        ]);
    }
}
