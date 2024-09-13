<?php

namespace App\Controller\Frontend;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Entity\Terrains;
use App\Entity\Reservations;
use App\Filter\TerrainFilter;
use App\Form\ReservationsType;
use App\Form\TerrainFilterType;
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
    ) {}


    #[Route('', '.index', methods: ['GET'])]
    public function index(Request $request, TerrainsRepository $terrainRepository): Response
    {

        $terrains = $this->terrainRepo->FindAllEnableByDate();


        // $terrainFilter = (new TerrainFilter)
        //     ->setPage($request->query->get('page', 1));

        // $form = $this->createForm(TerrainFilterType::class, $terrainFilter );
        // $form->handleRequest($request);

        // $terrains = $this->terrainRepo->findFilterListShop($terrainFilter);

        $filter = new TerrainFilter();
        $form = $this->createForm(TerrainFilterType::class, $filter);
        $form->handleRequest($request);

        $terrains = $terrainRepository->findByFilter($filter);


        return $this->render('Frontend/terrains/index.html.twig', [
            'terrains' => $terrains,
            // 'form' => $form
            'form' => $form->createView(),

        ]);
    }

    #[Route('/{slug}', '.show', methods: ['GET', 'POST'])]
    public function show(?Terrains $terrain, Request $request): Response
    {
        $user = $this->getUser();

        if (!$terrain) {
            $this->addFlash('error', 'aucune correspondace avec un terrain trouvé');

            return $this->redirectToRoute('app.terrains.index');
        }

        $allAvis = $this->avisRepo->findAllEnableByDate($terrain->getId());

        $avis = new Avis;

        $form = $this->createForm(AvisType::class, $avis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



            $avis
                ->setUser($user)
                ->setTerrain($terrain)
                ->setEnable(false);

            $this->em->persist($avis);
            $this->em->flush();


            $this->addFlash('success', 'votre avis à été publié avec succés');

            return $this->redirectToRoute('app.terrains.show', ['slug' => $terrain->getSlug()]);
        }



        $reservation = new Reservations;

        $resForm = $this->createForm(ReservationsType::class, $reservation, [
            'complexe_id' => $terrain->getComplexe()->getId()
        ]);
        $resForm->handleRequest($request);

        if ($resForm->isSubmitted() && $resForm->isValid()) {

            $reservation
                ->setUser($user)
                ->setTerrain($terrain);

            $this->em->persist($reservation);
            $this->em->flush();

            $this->addFlash('success', 'votre reservation est confirmé');

            return $this->redirectToRoute('app.terrains.show', ['slug' => $terrain->getSlug()]);
        }





        return $this->render('Frontend/terrains/Show/index.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
            'allAvis' => $allAvis,
            'resForm' => $resForm,
            'totalAvis' => $this->avisRepo->findTotalAvis($terrain->getId())
        ]);
    }
}
