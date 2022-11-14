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
        return $this->render('hackathon/listeHackathon.html.twig', [
            'lesHackathons' => $repository->findDate() #on récupère tout les hackathons qu'on passera en param lors du rendu
        ]);
    }

    #[Route('/hackathon/{id}', name: 'app_informationhackathon')]
    public function afficheInfo($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackathon::class);
        $leHackathon = $repository->find($id);
        return $this->render('hackathon/information.html.twig', [
            'leHackaton' => $leHackathon,
        ]);
    }
}
