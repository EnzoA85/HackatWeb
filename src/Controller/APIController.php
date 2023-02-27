<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Hackathon;
use App\Entity\Initiation;
use App\Entity\Participant;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/*use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;*/


class APIController extends AbstractController
{


    //api retournant un tableau de tout les hackathons
    #[Route('/api/hackathon', name: 'app_apiLesHackathons', methods: ['GET'])]
    public function apiLesHackathons(ManagerRegistry $doctrine): JsonResponse
    {
        //On recupère tout les hackathons
        
        $repository = $doctrine->getRepository(Hackathon::class);
        $lesHackathons = $repository->findAll();

        //On créé et remplit un tableau avec tout les hackathons
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
        //Renvoit du tableau des hackathons en JS
        return new JsonResponse($tableauHackathons, 200, ['Access-Control-Allow-Origin'=>'*']);
    }



    //api d'un seul hacathon via l'id
    #[Route('/api/hackathon/{id}', name: 'app_apiUnHackathon', methods: ['GET'])]
    public function apiUnHackathon($id,  ManagerRegistry $doctrine): Response
    {
        //On recherche un hackathon via l'id de l'url parmis tout les hackathons
        $repository = $doctrine->getRepository(Hackathon::class);
        $leHackathon = $repository->findOneBy(['id' => $id]);

        // On créé et remplit un tableau pour le hackathon
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

        // retour du tableau en reponse JS
        return new JsonResponse($tableauHackathon, 200, ['Access-Control-Allow-Origin'=>'*']);
    }




    // route qui permet de créer un atelier d'initiation
    #[Route('/api/postAtelier', name: 'app_apiAjoutAtelier', methods: ['POST'])]
    public function apiAjoutAtelier( Request $request, ManagerRegistry $doctrine)
    /* [FORME DU JSON DE LA REQUETE]
    {
    "libelle" : <libelle>, (string)
    "hackathon" : <hackathon>, (int)
    "date" : <date>, (string)
    "duree" : <duree>, (int)
    "heure" : <heure>, (string)
    "salle" : <salle>, (string)
    "nbplaces" : <nbplaces> (int)
    }
    */
    {
        $entityManager = $doctrine->getManager();

        // recupere le contenu du fichier json + décode
        $request = $request->getContent();
        $request = json_decode($request, true);

        $hackaton = $doctrine->getRepository(Hackathon::class)->findOneBy(['id' => $request["hackathon"]]);

        //on set le particpant
        $initiation = new Initiation();
        $initiation->setLibelle($request["libelle"]);
        $initiation->setIdHackathon($hackaton);
        $initiation->setDate(new \DateTime($request["date"]));
        $initiation->setHeure(new \DateTime($request["heure"]));
        $initiation->setSalle($request["salle"]);
        $initiation->setNbPlaceLimite($request["nbplaces"]);

        $entityManager->persist($initiation);
        $entityManager->flush();
    }




    //route pour recup les ateliers d'un hackaton
    #[Route('/api/ateliers/{id}', name: 'app_apiUnAtelier', methods: ['GET'])]
    public function apiAteliersHackathon( $id, ManagerRegistry $doctrine): Response
    {
        // recuperer les ateliers avec l'id
        $entityManager = $doctrine->getManager();
        $lesAteliers = $doctrine->getRepository(Initiation::class)->findBy(['Hackathon' => $id]);

        $tableauAtelier = [];
        foreach($lesAteliers as $atelier){
            $tableauAtelier[]=[
                "id" => $atelier->getId(),
                "libelle" => $atelier->getLibelle(),
                "date" => $atelier->getDate(),
                "heure" => $atelier->getHeure(),
                "salle" => $atelier->getSalle(),
                "nbPlaceLimite" => $atelier->getNbPlaceLimite()
            ];
        }
        return new JsonResponse($tableauAtelier, 200, ['Access-Control-Allow-Origin'=>'*']);
    }



    // route qui renvois les infos d'un participant
    #[Route('/api/postParticipant', name: 'app_apiAjoutParticpant', methods: ['POST'])]
    public function apiAjoutParticpant( Request $request, ManagerRegistry $doctrine)
    /* [FORME DU JSON DE LA REQUETE]
    {
    "nom" : <nom>, (string)
    "prenom" : <prenom>, (string)
    "mail" : <mail> (string)
    }
    */
    {
        $entityManager = $doctrine->getManager();

        // recupere le contenu du fichier json + décode
        $request = $request->getContent();
        $request = json_decode($request, true);

        //on set le particpant
        $participant = new Participant();
        $participant->setNom($request["nom"]);
        $participant->setPrenom($request["prenom"]);
        $participant->setmail($request["mail"]);

        $entityManager->persist($participant);
        $entityManager->flush();
    }



    //api retournant un tableau de tout les participants
    #[Route('/api/participants', name: 'app_apiLesParticipants', methods: ['GET'])]
    public function apiLesParticipants(ManagerRegistry $doctrine): JsonResponse
    {
        //On recupère tout les Participants
        
        $repository = $doctrine->getRepository(Participant::class);
        $lesParticipants = $repository->findAll();

        //On créé et remplit un tableau avec tout les participants
        $tableauParticipants=[];

        //Boucle pour récupérer les informations de chaque participant
        foreach($lesParticipants as $leParticipant){
            $tableauParticipants[] = [
                    'id'=>$leParticipant->getId(),
                    'nom'=>$leParticipant->getNom(),
                    'prenom'=>$leParticipant->getPrenom(),
                    'mail'=>$leParticipant->getMail(),
                    'atelier'=>$leParticipant->getInitiation()->getId()
            ];
            }   
        //Renvoit du tableau des participants en JS
        return new JsonResponse($tableauParticipants, 200, ['Access-Control-Allow-Origin'=>'*']);
    }



    //api d'un seul participant via l'id
    #[Route('/api/participant/{id}', name: 'app_apiUnParticipant', methods: ['GET'])]
    public function apiUnParticpant($id,  ManagerRegistry $doctrine): Response
    {
        //On recherche un particpant via l'id de l'url parmis tout les participants
        $repository = $doctrine->getRepository(Participant::class);
        $laParticipant = $repository->findOneBy(['id' => $id]);

        // On créé et remplit un tableau pour le participant
        $tableauParticipant=[];
        $tableauParticipant[]=[
            'id'=>$laParticipant->getId(),
            'nom'=>$laParticipant->getNom(),
            'prenom'=>$laParticipant->getPrenom(),
            'mail'=>$laParticipant->getMail(),
            'Atelier'=>$laParticipant->getInitiation()->getId()
        ];

        // retour du tableau en reponse JS
        return new JsonResponse($tableauParticipant, 200, ['Access-Control-Allow-Origin'=>'*']);
    }



    //route pour inscrire un participant à un atelier d'initiation
    #[Route('/api/InscriptionParticipant', name: 'app_apiInscriptionParticipant', methods: ['POST'])]
    public function apiInscriptionParticipant(Request $request, ManagerRegistry $doctrine)
    /* [FORME DU JSON DE LA REQUETE]
    {
    "idInitiation" : <id>, (int)
    "idParticipant" : <id> (int)
    }
    */
    {
        $entityManager = $doctrine->getManager();

        // recupere le contenu du fichier json + décode
        $request = $request->getContent();
        $request = json_decode($request, true);

        //on recup les objets à partir des id de la requette
        $participant = $doctrine->getRepository(Participant::class)->findOneBy(['id' => $request["idParticipant"]]);
        $initiation = $doctrine->getRepository(Initiation::class)->findOneBy(['id' => $request["idInitiation"]]);

        //on enregistre le participant
        $participant->setInitiation($initiation);
        $entityManager->persist($participant);
        $entityManager->flush();

        //on enregistre l'atelier
        $initiation->addParticipant($participant);
        $entityManager->persist($initiation);
        $entityManager->flush();
    }
}
