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
    #[Route('/inscription/{uc}', name: 'app_inscription')]
    public function index($uc, ManagerRegistry $doctrine): Response
    {
        if($uc == "form")
            return $this->render('inscription/index.html.twig', ['uc' => 'form']);
        else if ($uc == "validation") {
            $inscription = new Inscription();
            $inscription->setTexteLibre($_POST["texteLibre"]);
            $inscription->setDateInscription(new \DateTime(date_default_timezone_get()));
            $inscription->setHackathon($doctrine->getRepository(Hackathon::class)->findOneBy(['id' => $_POST["hackathon"]]));
            $inscription->setUtilisateur($doctrine->getRepository(Utilisateur::class)->findOneBy(['id' => $_POST["utilisateur"]]));
            $entityManager = $doctrine->getManager();
            $entityManager->persist($inscription);
            $entityManager->flush();
            return $this->render('home/index.html.twig');
        }
    }
}
