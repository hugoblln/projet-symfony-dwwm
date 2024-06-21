<?php

namespace App\Controller\Frontend;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Entity\Terrains;
use App\Entity\Reservations;
use App\Form\ReservationsType;
use App\Repository\AvisRepository;
use App\Repository\CreneauxRepository;
use App\Repository\TerrainsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/terrains', 'app.terrains')]
class TerrainController extends AbstractController
{

    public function __construct(
        private TerrainsRepository $terrainRepo,
        private EntityManagerInterface $em,
        private AvisRepository $avisRepo,
        private CreneauxRepository $creneauxRepo
    ) {
    }


    #[Route('', '.index', methods: ['GET'])]
    public function index(): Response
    {

        $terrains = $this->terrainRepo->FindAllEnableByDate();

        // $averageRatings = [];

        // foreach ($terrains as $terrain) {
        //     $averageRatings[$terrain->getId()] = $this->avisRepo->findAverage($terrain->getId());
        // }


        return $this->render('Frontend/terrains/index.html.twig', [
            'terrains' => $terrains,
            // 'averageRatings' => $averageRatings
        ]);
    }

    #[Route('/ville/{ville}', '.ville', methods: ['GET'])]
    public function indexByVille(string $ville): Response
    {

        $terrains = $this->terrainRepo->findByVille($ville);


        $message = "";

        if (empty($terrains)) {
            $message = 'Aucun terrain disponible pour cette ville';
        }

        return $this->render('Frontend/terrains/indexByVille.html.twig', [
            'message' => $message,
            'ville' => $ville,
            'terrains' => $terrains,

        ]);
    }


    #[Route('/{slug}', '.show', methods: ['GET', 'POST'])]
    public function show(?Terrains $terrain, Request $request): Response
    {
        if (!$terrain) {
            $this->addFlash('error', 'aucune correspondace avec un terrain trouvé');

            return $this->redirectToRoute('app.terrains.index');
        }

        $allAvis = $this->avisRepo->findAllEnableByDate($terrain->getId());

        $avis = new Avis;

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();

            $avis
                ->setUser($user)
                ->setTerrain($terrain)
                ->setEnable(true);

            $this->em->persist($avis);
            $this->em->flush();


            $this->addFlash('success', 'votre avis à été publié avec succés');

            return $this->redirectToRoute('app.terrains.show', ['slug' => $terrain->getSlug()]);
        }

        // $creneaux = $this->creneauxRepo->findCreneauxComplexe($terrain->getComplexe()->getId());

        $reservation = new Reservations;

        $resForm = $this->createForm(ReservationsType::class, $reservation, [
            'complexe_id' => $terrain->getComplexe()->getId()
        ]);

        
        var_dump($resForm->getData());



        return $this->render('Frontend/terrains/show.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
            'allAvis' => $allAvis,
            // 'creneaux' => $creneaux,
            'resForm' =>$resForm
        ]);
    }
}
