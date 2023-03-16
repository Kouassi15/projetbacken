<?php

namespace App\Controller;

use App\Entity\Hopital;
use App\Repository\CommuneRepository;
use App\Repository\HopitalRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HopitalController extends AbstractController
{

    private $repoCommune;
    private $repoSpecialite;
    private $repoHopital;
    public function __construct(CommuneRepository $repoCommune, SpecialiteRepository $repoSpecialite, HopitalRepository $repoHopital)
    {
        $this->repoCommune = $repoCommune;
        $this->repoSpecialite = $repoSpecialite;
        $this->repoHopital = $repoHopital;
    }

    #[Route('/ajouter/hopital', name: 'app_hopital', methods: ["POST"])]
    public function addHopital(Request $request): JsonResponse
    {
        // get data request
        $request_data = json_decode($request->getContent(), true);

        // enregistrer le medecin
        $hopital = new Hopital();
        $hopital->setNom($request_data["nom"]);
        $hopital->setLatitude($request_data["longitude"]);
        $hopital->setLongitude($request_data["latitude"]);
        // je recupere la specialite a partir de l'id
        $specialite =  $this->repoSpecialite->findOneById($request_data["id_specialite"]);
        $hopital->addSpecialite($specialite);
        // je recupere la commune a partir de l'id
        $commune =  $this->repoCommune->findOneById($request_data["id_commune"]);
        $hopital->setCommune($commune);

        // save
        $this->repoHopital->save($hopital, true);

        return $this->json([
            'code' => 200,
            'message' => 'Hopital enregistre',
        ]);
    }

    #[Route('/tous/hopital', name: 'app_hopital_tous', methods: ["GET"])]
    public function allHopital(Request $request): JsonResponse
    {
        $hopital = $this->repoHopital->findAll();
        return $this->json($hopital, 200, [], ['groups' => 'show_hopital']);
    }

}
