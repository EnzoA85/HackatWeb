<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{
    #[Route('/SignUp', name: 'app_créercompte')]
    public function créercompte(ManagerRegistry $doctrine, Request $request, UserPasswordHasherInterface $passwordHasher)
    {
        $user = new Utilisateur(); 
        $entityManager = $doctrine->getManager();
        $form=$this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $plaintextPassword = $form['mdp']->getData();
            $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
            );
            $user->setRoles(['ROLE_USER']);
            $user->setPassword($hashedPassword);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/creercompte.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/profil', name:'app_profil')]
    public function profil()
    {
        return $this->render('user/profil.html.twig', []);
    }
}
