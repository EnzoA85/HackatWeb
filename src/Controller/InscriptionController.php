<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hackathon;
use App\Entity\Inscription;
use App\Form\InscriptionHackathonType;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name:'app_inscription')]
    public function index(ManagerRegistry $doctrine,Request $request): Response
    {
        if ($this->getUser()==null)
        {
            return $this->render('home/index.html.twig', ['controller_name' => 'HomeController',]);
        } else {
            $inscription = new Inscription;
            $entityManager = $doctrine->getManager();
            $form=$this->createForm(InscriptionHackathonType::class,$inscription);        
            $form->handleRequest($request);
            $user = $this->getUser();
            if($form->isSubmitted() && $form->isValid()){
                $inscription->setUtilisateur($user);
                $inscription->setDateInscription(new DateTime('now'));
                $entityManager->persist($inscription);
                $entityManager->flush();
                return $this->redirectToRoute('app_home');
            }
            return $this->render('inscription/index.html.twig',['form'=>$form->createView()]);
        }
    }

    #[Route('/ValidationInscription', name: 'app_ValiderInscription')]
    public function validercreercompte(ManagerRegistry $doctrine)
    {
            // on change rentre chaque paramètres
            $inscription = new Inscription();
            $inscription->setTexteLibre($_POST["texteLibre"]);
            $inscription->setDateInscription(new \DateTime(date_default_timezone_get()));

            $inscription->setHackathon($doctrine->getRepository(Hackathon::class)->findOneBy(['id' => $_POST["hackathon"]])); // on cherche un hackathon par rapport à l'id entrée
            $inscription->setUtilisateur($this->getUser()); // on cherche un utilisateur par rapport à l'utilisateur connecté
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
            return $this->render('home/index.html.twig');
    }


}
