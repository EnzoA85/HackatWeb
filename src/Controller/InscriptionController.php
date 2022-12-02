<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hackathon;
use App\Entity\Utilisateur;
use App\Entity\Inscription;
use Doctrine\Persistence\ManagerRegistry;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index( ManagerRegistry $doctrine): Response
    /*
    [route pour la page d'inscription]

    Fonctionne avec les cas d'utilisateurs (uc) :
    si l'uc est form (valeur de base), alors on render la page avec le formulaire pour s'inscrire.
    si l'uc est validation, on enregistre les informations dans la bdd avant de render la page principale du site.
    */
    {
        return $this->render('inscription/index.html.twig');
    }

    #[Route('/ValidationInscription', name: 'app_ValiderInscription')]
    public function validercreercompte(ManagerRegistry $doctrine)
    {
            // on change rentre chaque paramètres
            $inscription = new Inscription();
            $inscription->setTexteLibre($_POST["texteLibre"]);
            $inscription->setDateInscription(new \DateTime(date_default_timezone_get()));

            $inscription->setHackathon($doctrine->getRepository(Hackathon::class)->findOneBy(['id' => $_POST["hackathon"]])); // on cherche un hackathon par rapport à l'id entrer
            $inscription->setUtilisateur($this->getUser()); // on cherche un utilisateur par rapport à l'utilisateur connecter
            
            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
            return $this->render('home/index.html.twig');
    }
}
