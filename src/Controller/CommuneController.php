<?php

namespace App\Controller;

use App\Entity\Commune;
use App\Repository\CommuneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommuneController extends AbstractController
{

    private $repoCommune;
    public function __construct(CommuneRepository $repoCommune)
    {
        $this->repoCommune = $repoCommune;
    }

    #[Route('/ajouter/commune', name: 'app_commune', methods: ["POST"])]
    public function addCommune(Request $request): JsonResponse
    {

        // get data request
        $request_data = json_decode($request->getContent(), true);

        // check if username exist
        $verifCommune = $this->repoCommune->findOneByNom($request_data["nom"]);
        if ($verifCommune != null) {
            return $this->json([
                'code' => 401,
                'message' => "Le nom de la commune est déjà utilisé."
            ]);
        }

        // enregistre la commune
        $commune = new Commune();
        $commune->setNom($request_data["nom"]);
        $commune->setDescription($request_data["description"]);
        // save user
        $this->repoCommune->save($commune, true);

        return $this->json([
            'code' => 200,
            'message' => 'Commune enregistree',
        ]);
    }

    #[Route('/tous/commune', name: 'app_commune_tous', methods: ["GET"])]
    public function allCommune(Request $request): JsonResponse
    {

        $commune = $this->repoCommune->findAll();
        return $this->json($commune, 200, [], ['groups' => 'show_commune']);
    }

}
