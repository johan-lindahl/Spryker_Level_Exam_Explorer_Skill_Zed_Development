<?php

namespace Pyz\Zed\Antelope\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;

class LocationMapper
{
    public function mapLocationTransferCollection(iterable $locationEntities, AntelopeLocationCollectionTransfer $locationCollectionTransfer): AntelopeLocationCollectionTransfer
    {
        foreach ($locationEntities as $locationEntity) {
            $t = new AntelopeLocationTransfer();
            $locationTransfer = $t->fromArray($locationEntity->toArray(), true);
            $locationCollectionTransfer->addLocation($locationTransfer);
        }

        return $locationCollectionTransfer;
    }
}
