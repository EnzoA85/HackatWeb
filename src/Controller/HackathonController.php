<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hackathon;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class HackathonController extends AbstractController
{
    #[Route('/hackathon', name: 'app_listeHackathon')]
    public function afficheList(ManagerRegistry $doctrine): Response
    {
<<<<<<< HEAD
        $repositoryHackathons = $doctrine->getRepository(Hackathon::class); #recuperation du repository des Hackathons
        return $this->render('hackathon/listeHackathon.html.twig', [
            'lesHackathons' => $repositoryHackathons->findAll(), #on récupère tout les hackathons qu'on passera en param lors du rendu
=======
        $repository = $doctrine->getRepository(Hackathon::class); #recuperation du repository des Hackathons
        $listeHackat = [];
        foreach ($repository->findAll() as $hackathon ){
            $listeHackat[] = array("infoHackathon" => $hackathon, "placesDispo" => ($hackathon->getNbPlaces() - $hackathon->getLesInscriptions()->count()));
        }
        return $this->render('hackathon/listeHackathon.html.twig', [
            'lesHackathons' => $listeHackat, #on récupère tout les hackathons qu'on passera en param lors du rendu
>>>>>>> 8a80ca004f970b42b28892979acc455ae3002329
        ]);
    }

    #[Route('/hackathons', name: 'app_rechercheListeHackathon')]
    public function afficheRechercheList(ManagerRegistry $doctrine): Response
    {
        $recherche = $_POST['searchHackathon'];
        $repository = $doctrine->getRepository(Hackathon::class); #recuperation du repository des Hackathons
        // [[hackathon : hackat, place dispo : nb], [hackathon : hackat, place dispo : nb]]
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
<<<<<<< HEAD
        $nbPlaceRestantes = $leHackathon->getNbPlaces()-count($leHackathon->getLesInscriptions());

        return $this->render('hackathon/information.html.twig', [
            'leHackaton' => $leHackathon,'nbPlaceRestantes' => $nbPlaceRestantes
=======
        $placesDispo = $leHackathon->getNbPlaces() - $leHackathon->getLesInscriptions()->count();
        return $this->render('hackathon/information.html.twig', [
            'leHackaton' => $leHackathon, "placesDispo" => $placesDispo
>>>>>>> 8a80ca004f970b42b28892979acc455ae3002329
        ]);
    }
}
