<?php

namespace App\Twig;

use App\Entity\Terrains;
use App\Repository\AvisRepository;
use App\Repository\TerrainsRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Webmozart\Assert\Assert;

class TerrainExtension extends AbstractExtension
{
    public function __construct(private AvisRepository $avisRepo)
    {
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('terrain_average', [$this, 'getAverage']),
        ];
    }

    public function getAverage(Terrains $terrain): float
    {
        return $this->avisRepo->findAverage($terrain->getId());
    }
}
