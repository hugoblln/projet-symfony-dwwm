<?php

namespace App\Controller\Frontend;

use App\Entity\Terrains;
use App\Repository\TerrainsRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/terrains', 'app.terrains')]
class TerrainController extends AbstractController
{

    public function __construct(
        private TerrainsRepository $terrainRepo
    ) {
    }


    #[Route('', '.index', methods: ['GET'])]
    public function index(): Response
    {

        return $this->render('Frontend/terrains/index.html.twig', [
            'terrains' => $this->terrainRepo->FindAllEnableByDate()
        ]);
    }

    #[Route('/ville/{ville}', '.ville', methods: ['GET'])]
    public function TerrainsByVille(string $ville): Response
    {

        $terrains = $this->terrainRepo->findByVille($ville);

        $message = "";

        if (empty($terrains)) {
            $message = 'Aucun terrain disponible pour cette ville';
        }

        return $this->render('Frontend/terrains/indexByVille.html.twig', [
            'message' => $message,
            'ville' => $ville,
            'terrains' => $terrains
        ]);
    }


    #[Route('/{slug}', '.show', methods: ['GET'])]
    public function show(?Terrains $terrain): Response
    {
        if (!$terrain) {
            $this->addFlash('error', 'aucune correspondace avec un terrain trouvé');

            return $this->redirectToRoute('app.terrains.index');
        }

        return $this->render('Frontend/terrains/show.html.twig', [
            'terrain' => $terrain
        ]);
    }
}
