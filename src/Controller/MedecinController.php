<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MedecinController extends AbstractController
{

    private $repoMedecin;
    private $repoSpecialite;
    public function __construct(MedecinRepository $repoMedecin, SpecialiteRepository $repoSpecialite)
    {
        $this->repoMedecin = $repoMedecin;
        $this->repoSpecialite = $repoSpecialite;
    }

    #[Route('/ajouter/medecin', name: 'app_medecin', methods: ["POST"])]
    public function addMedecin(Request $request): JsonResponse
    {
        // get data request
        $request_data = json_decode($request->getContent(), true);

        // enregistrer le medecin
        $medecin = new Medecin();
        $medecin->setNom($request_data["nom"]);
        $medecin->setPrenom($request_data["prenom"]);
        $medecin->setContact($request_data["contact"]);
        // je recupere la specialite a partir de l'id
        $specialite =  $this->repoSpecialite->findOneById($request_data["id_specialite"]);
        $medecin->addSpecialite($specialite);

        // save
        $this->repoMedecin->save($medecin, true);

        return $this->json([
            'code' => 200,
            'message' => 'Medecin enregistre',
        ]);
    }

    #[Route('/tous/medecin', name: 'app_medecin_tous', methods: ["GET"])]
    public function allCommune(Request $request): JsonResponse
    {

        $medecin = $this->repoMedecin->findAll();
        return $this->json($medecin, 200, [], ['groups' => 'show_medecin']);
    }
}
