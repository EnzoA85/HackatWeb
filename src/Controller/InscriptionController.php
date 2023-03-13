<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hackathon;
use App\Entity\Inscription;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index( ManagerRegistry $doctrine): Response
    {
        $hackathons = [];
        foreach ($doctrine->getRepository(Hackathon::class)->findAll() as $hackathon){
            $listeInscription = $doctrine->getRepository(Inscription::class)->findBy(["hackathon" => $hackathon, "utilisateur" => $this->getUser()]);
            if (count($listeInscription) == 0 && $hackathon->getDateLimite() > date("YYYY-MM-DD")){
                $hackathons[] = $hackathon;
            }
        }
        return $this->render('inscription/index.html.twig', ["les_hackathons" => $hackathons]);
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

    #[Route('/favoriHackathon/{id}', name: 'app_MettreFavoris')]
    public function mettreFavoriHackathon($id, ManagerRegistry $doctrine)
    {
        #recupération de l'utilisateur
        $Utilisateur = $this->getUser();
        #recupération du hackathon
        $Hackathon = $doctrine->getRepository(Hackathon::class)->findOneBy(array('id' => $id));
        
        #Mettre le hackathon en favoris
        $Utilisateur->addFavori($Hackathon);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($Utilisateur);
        $entityManager->flush();

        return $this->render('/hackathons');
    }

}
