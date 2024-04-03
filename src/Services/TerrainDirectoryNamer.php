<?php

namespace App\Services;

use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class TerrainDirectoryNamer implements DirectoryNamerInterface
{
    public function directoryName(mixed $object, PropertyMapping $mapping): string 
    {
    
        if($object->getTerrain()) {
            return $object->getTerrain()->getNom();
        }

    }
}