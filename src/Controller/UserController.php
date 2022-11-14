<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Utilisateur;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', ['controller_name' => 'UserController',]);
    }

    #[Route('/SignUp', name: 'app_créercompte')]
    public function créercompte(): Response
    {
        return $this->render('user/creercompte.html.twig');
    }

    #[Route('/ValidationSignUp', name: 'app_Validercreercompte')]
    public function validercreercompte(ManagerRegistry $doctrine)
    {
        $nom=$_POST["nom"];
        $prenom=$_POST["prenom"];
        $email=$_POST["email"];
        $dateNaissance=$_POST["dateNaissance"];
        $tel=$_POST["tel"];
        $lienportfolio=$_POST["portfolio"];
        $mdp=$_POST["mdp"];
        $confmdp=$_POST["confmdp"];
        if($mdp==$confmdp)
        {
            $user = new Utilisateur();
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setMail($email);
            $user->setDateNaissance(new \DateTime($dateNaissance));
            $user->setTel($tel);
            $user->setLienPortfolio($lienportfolio);
            $user->setMdp($mdp);
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->render('user/ValidationSignUp.html.twig', ['nom' => $nom, 'prenom' => $prenom, 'email'=>$email,'dateNaissance'=>$dateNaissance,'tel'=>$tel,'portfolio'=>$lienportfolio,]); 
        }
    }
}
