<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Hackathon;
use Symfony\Component\HttpFoundation\JsonResponse;

/*use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;*/


class APIController extends AbstractController
{
    //api retournant un tableau de tout les hackathons
    #[Route('/api', name: 'app_apiLesHackathons')]
    public function apiLesHackathons(ManagerRegistry $doctrine): JsonResponse
    {
        
        $repository = $doctrine->getRepository(Hackathon::class);
        $lesHackathons = $repository->findAll();
        $tableauHackathons=[];

        //Boucle pour récupérer les informations de chaque hackathon
        foreach($lesHackathons as $leHackathon){
            $tableauHackathons[] = [
                    'id'=>$leHackathon->getId(),
                    'dateDebut'=>$leHackathon->getDateDebut(),
                    'lieu'=>$leHackathon->getLieu(),
                    'rue'=>$leHackathon->getRue(),
                    'ville'=>$leHackathon->getVille(),
                    'codePostal'=>$leHackathon->getCodePostal(),
                    'theme'=>$leHackathon->getTheme(),
                    'description'=>$leHackathon->getDescription(),
                    'image'=>$leHackathon->getImage(),
                    'nbPlaces'=>$leHackathon->getNbPlaces(),
                    'heureDebut'=>$leHackathon->getHeureDebut(),
                    'dateFin'=>$leHackathon->getDateFin(),
                    'heureFin'=>$leHackathon->getHeureFin(),
                    'dateLimite'=>$leHackathon->getDateLimite()
            ];
            }   
  
        return new JsonResponse($tableauHackathons);
    }

    //api d'un seul hacathon via l'id
    #[Route('/api/{id}', name: 'app_apiUnHackathon')]
    public function apiUnHackathon($id,  ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Hackathon::class);
        $leHackathon = $repository->findOneBy(['id' => $id]);

        $tableauHackathon=[];
        $tableauHackathon[]=[
            'id'=>$leHackathon->getId(),
            'dateDebut'=>$leHackathon->getDateDebut(),
            'lieu'=>$leHackathon->getLieu(),
            'rue'=>$leHackathon->getRue(),
            'ville'=>$leHackathon->getVille(),
            'codePostal'=>$leHackathon->getCodePostal(),
            'theme'=>$leHackathon->getTheme(),
            'description'=>$leHackathon->getDescription(),
            'image'=>$leHackathon->getImage(),
            'nbPlaces'=>$leHackathon->getNbPlaces(),
            'heureDebut'=>$leHackathon->getHeureDebut(),
            'dateFin'=>$leHackathon->getDateFin(),
            'heureFin'=>$leHackathon->getHeureFin(),
            'dateLimite'=>$leHackathon->getDateLimite()
        ];
        return new JsonResponse($tableauHackathon);
    }
}
