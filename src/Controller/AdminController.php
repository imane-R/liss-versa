<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Service;
use App\Entity\Produits;
use App\Entity\Categorie;
use App\Form\ServiceType;
use App\Form\ProduitsType;
use App\Form\CategorieType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Repository\ServiceRepository;
use App\Repository\ProduitsRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/admin', name: 'admin_')] // cette route est commune à atoutes celle qui se trouvent dans ce controller 
class AdminController extends AbstractController
{
    // --------------------------------Admin Categories ---------------------------------------//

    #[Route('/categorie_add', name: 'add_categorie')]
    public function add(Request $request, CategorieRepository $repo, SluggerInterface $slugger): Response
    {
        $categorie = new Categorie;
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //ajouter un vaaluer dans slug de la database
            $slug = $slugger->slug($form->get('nom')->getData());

            $categorie->setSlug($slug);
            $repo->save($categorie, 1);
            return $this->redirectToRoute('admin_categories');
        }
        return $this->render("admin/categorie/form.html.twig", [
            'formCategorie' => $form->createView()
        ]);
    }
    #[Route('/categories', name: 'categories')]
    public function showAll(CategorieRepository $repo)
    {
        $categories = $repo->findAll();
        return $this->render("admin/categorie/showAllCategories.html.twig", [
            'categories' => $categories
        ]);
    }

    #[Route('/categorie_update_{slug}', name: 'categorie_update')]
    public function update($slug, Request $request, CategorieRepository $repo, SluggerInterface $slugger)
    {
        $categorie = $repo->findOneBy(['slug' => $slug]);
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug =  $slugger->slug($categorie->getNom());
            $categorie->setSlug($slug);
            $repo->save($categorie, 1);
            return $this->redirectToRoute('admin_categories');
        }
        return $this->render('admin/categorie/form.html.twig', [
            'formCategorie' => $form->createView()
        ]);
    }
    #[Route('/categorie_delete_{slug}', name: 'categorie_delete')]
    public function delete($slug, CategorieRepository $repo)
    {
        $categorie = $repo->findOneBy(['slug' => $slug]);
        $repo->remove($categorie, 1);
        return $this->redirectToRoute('admin_categories');
    }

    // -------------------------------- end Admin Categories ---------------------------------------//

    // --------------------------------Admin Service ----------------------------------------------//

    #[Route('/service_add', name: 'add_service')]
    public function addService(Request $request, ServiceRepository $repo, SluggerInterface $slugger): Response
    {
        $service = new Service;
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageForm')->getData();
            if ($file) {
                $fileName = $slugger->slug($service->getTitre()) . uniqid() . '.' . $file->guessExtension();
                try {
                    //pn cherche à enregistrer l'image du formulaire dans notre dossier paramétré dans service.yaml "service_images" sous le nom q'on a crée "$titre"
                    $file->move($this->getParameter('service_images'), $fileName);
                } catch (FileException $e) {
                    //gérer les exceptions en cas d'erreur durant l'upload d'un article
                }
                $service->setImage($fileName);
            }

            //ajouter un vaaluer dans slug de la database
            $slug = $slugger->slug($form->get('titre')->getData());

            $service->setSlug($slug);
            $repo->save($service, 1);
            return $this->redirectToRoute('admin_services');
        }
        return $this->render("admin/services/form.html.twig", [
            'formService' => $form->createView()
        ]);
    }

    #[Route('/services', name: 'services')]
    public function showAllService(ServiceRepository $repo)
    {
        $services = $repo->findAll();
        // dd($services);
        return $this->render("admin/services/showAllService.html.twig", [
            'services' =>  $services
        ]);
    }
    #[Route('/service_update_{id<\d+>}', name: 'service_update')]
    public function updateService($id, Request $request, ServiceRepository $repo, SluggerInterface $slugger)
    {
        $service = $repo->find($id);
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageForm')->getData();
            if ($file) {
                $fileName = $slugger->slug($service->getTitre()) . uniqid() . '.' . $file->guessExtension();
                try {
                    //pn cherche à enregistrer l'image du formulaire dans notre dossier paramétré dans service.yaml "service_images" sous le nom q'on a crée "$titre"
                    $file->move($this->getParameter('service_images'), $fileName);
                } catch (FileException $e) {
                    //gérer les exceptions en cas d'erreur durant l'upload d'un article
                }
                $service->setImage($fileName);
            }
            $slug =  $slugger->slug($service->getTitre());
            $service->setSlug($slug);
            $repo->save($service, 1);
            return $this->redirectToRoute('admin_services');
        }
        return $this->render('admin/services/form.html.twig', [
            'formService' => $form->createView()
        ]);
    }

    #[Route('/service_delete_{id<\d+>}', name: 'service_delete')]
    public function deleteService($id, ServiceRepository $repo)
    {
        $service =  $repo->find($id);
        $repo->remove($service, 1);
        return $this->redirectToRoute('admin_services');
    }
    #[Route('/service_details{id<\d+>}', name: 'services_details')]
    public function detailsService($id, ServiceRepository $repo)
    {
        // dd($repo);
        $service = $repo->find($id);
        return $this->render('admin/services/detailsService.html.twig', [
            'service' =>  $service
        ]);
    }


    // ------------------------------------------ Fin Admin Service --------------------------------------------------//

    // -------------------------------------------Admin Produits ----------------------------------------------------//

    #[Route('/produits_add', name: 'add_produits')]
    public function addProduit(Request $request, ProduitsRepository $repo, SluggerInterface $slugger): Response
    {
        $produits = new Produits;
        $form = $this->createForm(ProduitsType::class, $produits);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageForm')->getData();
            if ($file) {
                $fileName = $slugger->slug($produits->getTitre()) . uniqid() . '.' . $file->guessExtension();
                try {
                    //pn cherche à enregistrer l'image du formulaire dans notre dossier paramétré dans service.yaml "service_images" sous le nom q'on a crée "$titre"
                    $file->move($this->getParameter('produits_images'), $fileName);
                } catch (FileException $e) {
                    //gérer les exceptions en cas d'erreur durant l'upload d'un article
                }
                $produits->setImage($fileName);
            }

            //ajouter un vaaluer dans slug de la database
            $slug = $slugger->slug($form->get('titre')->getData());

            $produits->setSlug($slug);
            $repo->save($produits, 1);
            return $this->redirectToRoute('admin_produits');
        }
        return $this->render("admin/produit/form.html.twig", [
            'formProduits' => $form->createView()
        ]);
    }

    #[Route('/produits', name: 'produits')]
    public function showAllProduits(ProduitsRepository $repo)
    {
        $produits = $repo->findAll();
        // dd($services);
        return $this->render("admin/produit/showAllProduits.html.twig", [
            'produits' =>  $produits
        ]);
    }
    #[Route('/produit_update_{id<\d+>}', name: 'produit_update')]
    public function updateProduit($id, Request $request, ProduitsRepository $repo, SluggerInterface $slugger)
    {
        $produit = $repo->find($id);
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageForm')->getData();
            if ($file) {
                $fileName = $slugger->slug($produit->getTitre()) . uniqid() . '.' . $file->guessExtension();
                try {
                    $file->move($this->getParameter('service_images'), $fileName);
                } catch (FileException $e) {
                }
                $produit->setImage($fileName);
            }
            $slug =  $slugger->slug($produit->getTitre());
            $produit->setSlug($slug);
            $repo->save($produit, 1);
            return $this->redirectToRoute('admin_produits');
        }
        return $this->render('admin/produit/form.html.twig', [
            'formProduits' => $form->createView()
        ]);
    }

    #[Route('/produit_delete_{id<\d+>}', name: 'produit_delete')]
    public function deleteProduit($id, ProduitsRepository $repo)
    {
        $produit =  $repo->find($id);
        $repo->remove($produit, 1);
        return $this->redirectToRoute('admin_produits');
    }

    #[Route('/produit_details{id<\d+>}', name: 'produit_details')]
    public function detailsProduit($id, ProduitsRepository $repo)
    {
        // dd($repo);
        $produit = $repo->find($id);
        return $this->render('admin/produit/detailsProduit.html.twig', [
            'produit' =>  $produit
        ]);
    }

    // -------------------------------- end Admin produits ---------------------------------------//

    // --------------------------------Admin registration ----------------------------------------------//


    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_ADMIN']);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/user', name: 'app_user')]
    public function showAllUser(UserRepository $repo)
    {
        $users = $repo->findAll();
        // dd($services);
        return $this->render("registration/showallUsers.html.twig", [
            'users' =>  $users
        ]);
    }

    #[Route('/user_update_{id<\d+>}', name: 'user_update')]
    public function updateUser($id, Request $request, UserRepository $repo, UserPasswordHasherInterface $userPasswordHasher)
    {
        $user = $repo->find($id);
        $form = $this->createForm(RegistrationFormType::class,  $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_ADMIN']);
            $repo->save($user, 1);
            return $this->redirectToRoute('app_user');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    #[Route('/user_delete_{id<\d+>}', name: 'user_delete')]
    public function deleteUser($id, UserRepository $repo)
    {
        $user =  $repo->find($id);
        $repo->remove($user, 1);
        return $this->redirectToRoute('app_user');
    }
}
