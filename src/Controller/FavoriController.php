<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hackathon;
use App\Entity\Utilisateur;
use Doctrine\Persistence\ManagerRegistry;

class FavoriController extends AbstractController
{
    #[Route('/favoriHackathon/{id}', name: 'app_MettreFavoris')]
    public function mettreFavoriHackathon($id, ManagerRegistry $doctrine)
    {
        #recupération de l'utilisateur
        $Utilisateur = $this->getUser();
        #recupération du hackathon
        $Hackathon = $doctrine->getRepository(Hackathon::class)->findOneBy(array('id' => $id));
        
        #Mettre le hackathon en favori
        $Utilisateur->addFavori($Hackathon);
        $entityManager = $doctrine->getManager();
        $entityManager->persist($Utilisateur);
        $entityManager->flush();
 
        return $this->redirectToRoute("app_listeHackathon");
    }

    #[Route('/supprFavoriHackathon/{id}', name: 'app_SupprFavoris')]
    public function SupprFavoriHackathon($id, ManagerRegistry $doctrine)
    {
        #recupération de l'utilisateur
        $Utilisateur = $this->getUser();
        #recupération du hackathon
        $Hackathon = $doctrine->getRepository(Hackathon::class)->findOneBy(array('id' => $id));
        
        #Suppr le hackathon des favoris
        $Utilisateur->removeFavori($Hackathon);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($Utilisateur);
        $entityManager->flush();
 
        return $this->redirectToRoute("app_listeHackathon");
    }
}
