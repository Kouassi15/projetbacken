<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpecialiteController extends AbstractController
{
    
    private $repoSpecialite;
    public function __construct(SpecialiteRepository $repoSpecialite)
    {
        $this->repoSpecialite = $repoSpecialite;
    }

    #[Route('/ajouter/specialite', name: 'app_specialite', methods: ["POST"])]
    public function addCommune(Request $request): JsonResponse
    {

        // get data request
        $request_data = json_decode($request->getContent(), true);

        // check if username exist
        $verifSpecialite = $this->repoSpecialite->findOneByNom($request_data["nom"]);
        if ($verifSpecialite != null) {
            return $this->json([
                'code' => 401,
                'message' => "La specialite existe deja."
            ]);
        }

        // enregistre la specialite
        $specialite = new Specialite();
        $specialite->setNom($request_data["nom"]);
        // save user
        $this->repoSpecialite->save($specialite, true);

        return $this->json([
            'code' => 200,
            'message' => 'Specialite enregistree',
        ]);
    }

    #[Route('/tous/specialite', name: 'app_specialite_tous', methods: ["GET"])]
    public function allSpecialite(Request $request): JsonResponse
    {

        $specialites = $this->repoSpecialite->findAll();
        return $this->json($specialites, 200, [], ['groups' => 'show_specialite']);
    }

}
