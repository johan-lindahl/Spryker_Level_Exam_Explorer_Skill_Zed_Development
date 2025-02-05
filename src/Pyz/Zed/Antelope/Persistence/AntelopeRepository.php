<?php

namespace Pyz\Zed\Antelope\Persistence;

use Generated\Shared\Transfer\AntelopeCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;

/**
 * @method \Pyz\Zed\Antelope\Persistence\AntelopePersistenceFactory getFactory()
 */
class AntelopeRepository extends AbstractRepository implements
    AntelopeRepositoryInterface
{
    public function getAntelope(AntelopeCriteriaTransfer $antelopeCriteriaTransfer): ?AntelopeTransfer
    {
        $antelopeEntity = $this->getFactory()->createAntelopeQuery()->filterByName(
            $antelopeCriteriaTransfer->getName(),
        )->findOne();
        if (!$antelopeEntity) {
            $name = $antelopeCriteriaTransfer->getName();
            throw new EntityNotFoundException("Antelope {$name} not found");
        }

        $location = $this->getAntelopeLocationByIdInt($antelopeEntity->getFkAntelopeLocation());

        $antelopeDTO = (new AntelopeTransfer())->fromArray($antelopeEntity->toArray(), true);
        $antelopeDTO->setLocation($location);

        return $antelopeDTO;
    }

    public function getAntelopeLocationById(AntelopeLocationCriteriaTransfer $antelopeLocationCriteriaTransfer): ?AntelopeLocationTransfer
    {
        return $this->getAntelopeLocationByIdInt($antelopeLocationCriteriaTransfer->getIdLocation());
    }

    private function getAntelopeLocationByIdInt(int $locationId): ?AntelopeLocationTransfer
    {
        $antelopeLocationEntity = $this->getFactory()->createAntelopeLocationQuery()->filterByIdLocation(
            $locationId
        )->findOne();
        if (!$antelopeLocationEntity) {
            throw new EntityNotFoundException("Antelope Location {$locationId} not found");
        }
        return (new AntelopeLocationTransfer())->fromArray($antelopeLocationEntity->toArray(), true);
    }

    public function getAntelopeLocations(): AntelopeLocationCollectionTransfer
    {
        $locationEntities = $this->getFactory()
            ->createAntelopeLocationQuery()
            ->orderByLocationName()
            ->find();

        return $this->getFactory()
            ->createAntelopeLocationMapper()
            ->mapLocationTransferCollection($locationEntities, new AntelopeLocationCollectionTransfer());
    }   
}
