<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hackathon;
use Doctrine\Persistence\ManagerRegistry;

class HackathonController extends AbstractController
{
    #[Route('/hackathon', name: 'app_listeHackathon')]
    public function afficheList(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackathon::class); #recuperation du repository des Hackathons
        // liste hackathon = [[infoHackathon : hackathon, place dispo : nb], [infoHackathon : hackathon, place dispo : nb], ... ]
        $listeHackat = [];
        foreach ($repository->findAll() as $hackathon ){
            $listeHackat[] = array("infoHackathon" => $hackathon, "placesDispo" => ($hackathon->getNbPlaces() - $hackathon->getLesInscriptions()->count()));
        }
        return $this->render('hackathon/listeHackathon.html.twig', [
            'lesHackathons' => $listeHackat, #on récupère tout les hackathons qu'on passera en param lors du rendu
        ]);
    }

    #[Route('/hackathons', name: 'app_rechercheListeHackathon')]
    public function afficheRechercheList(ManagerRegistry $doctrine): Response
    {
        $recherche = $_POST['searchHackathon'];
        $repository = $doctrine->getRepository(Hackathon::class); #recuperation du repository des Hackathons
        // liste hackathon = [[infoHackathon : hackathon, place dispo : nb], [infoHackathon : hackathon, place dispo : nb], ... ]
        $listeHackat = [];
        foreach ($repository->findLikeVille($recherche) as $hackathon ){
            $listeHackat[] = array("infoHackathon" => $hackathon, "placesDispo" => ($hackathon->getNbPlaces() - $hackathon->getLesInscriptions()->count()));
        }
        return $this->render('hackathon/listeHackathon.html.twig', [
            'lesHackathons' => $listeHackat #on récupère tout les hackathons trié par date qu'on passera en param lors du rendu
        ]);
    }

    #[Route('/hackathon/{id}', name: 'app_informationhackathon')]
    public function afficheInfo($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackathon::class);
        $leHackathon = $repository->find($id);
        $placesDispo = $leHackathon->getNbPlaces() - $leHackathon->getLesInscriptions()->count();

        #On recherhe si un utilisateur est connecté
        $user = $this->getUser();
        if($user != null)
        {
            #On recherche si l'utilisateur connecté a mit ou non ce hackhaton 
            $lesFavoris=$user->getFavoris();
            /*foreach($favori in $lesFavoris)
            {
                
            }
            */
            $estFavoris = False;
            //var_dump($lesFavoris);
        }


        return $this->render('hackathon/information.html.twig', [
            'leHackaton' => $leHackathon, "placesDispo" => $placesDispo, "estFavoris" => $estFavoris, "listeFavs" => $lesFavoris,
        ]);
    }
}
