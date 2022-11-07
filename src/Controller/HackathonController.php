<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HackathonController extends AbstractController
{
    #[Route('/hackathon', name: 'app_hackathon')]
    public function index(): Response
    {
        return $this->render('hackathon/index.html.twig', [
            'controller_name' => 'HackathonController',
        ]);
    }
}
