<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{

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
