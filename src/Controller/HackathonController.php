<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Hackathon;

class HackathonController extends AbstractController
{
    #[Route('/hackathon/{id}', name: 'app_informationhackathon')]
    public function index($id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackathon::class);
        $leHackathon = $repository->find($id);
        return $this->render('hackathon/information.html.twig', [
            'leHackaton' => $leHackathon,
        ]);
    }
}
