<?php

namespace App\Controller;

use App\Entity\Hackathon;
use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
    public function profil(ManagerRegistry $doctrine,AuthenticationUtils $authenticationUtils)
    {
        $lastEmail = $authenticationUtils->getLastUsername();
        $repositoryUser = $doctrine->getRepository(Utilisateur::class);
        $repositoryInscription = $doctrine->getRepository(Inscription::class);
        $repositoryHackathon = $doctrine->getRepository(Hackathon::class);
        $user = $repositoryUser->findBy(['mail'=>$lastEmail]);
        $inscriptionsUser = $repositoryInscription->findBy(['utilisateur'=>$user[0]->getid()]);
        $inscription = [];
        foreach($inscriptionsUser as $inscriptionUser) {
            $hackathonInscrit = $repositoryHackathon->findBy(['id'=>$inscriptionUser->getHackathon()->getid()]);
            $inscription[] = $hackathonInscrit;
        }
        //on récupère l'utilisateur (enzo est débile et ne sait pas faire ça)
        $Utilisateur = $this->getUser();
        //récupération des favoris de l'utilisateur 
        $lesFavoris = $Utilisateur->getFavoris();

        return $this->render('user/profil.html.twig', [
            'user'=>$user[0], 'inscriptionsUser'=>$inscriptionsUser, 'lesFavoris'=>$lesFavoris
        ]);
    }

    #[Route('/ajouterFavori/{id}', name:'app_addFavori')]
    public function addFavori($id,ManagerRegistry $doctrine)
    {
        $hackathon = $doctrine->getRepository(Hackathon::class)->findBy(['id'=>$id]);
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();
        $user->addFavori($hackathon[0]);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_listeHackathon');
    }

    #[Route('/deleteFavori/{id}', name:'app_deleteFavori')]
    public function deleteFavori($id,ManagerRegistry $doctrine)
    {
        $hackathon = $doctrine->getRepository(Hackathon::class)->findBy(['id'=>$id]);
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();
        $user->removeFavori($hackathon[0]);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_listeHackathon');
    }
}
