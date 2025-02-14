<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Pyz\Zed\Antelope\Persistence;

use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\AntelopeTransfer;
use Orm\Zed\Antelope\Persistence\PyzAntelope;
use Orm\Zed\Antelope\Persistence\PyzAntelopeLocation;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\Antelope\Persistence\AntelopePersistenceFactory getFactory()
 */
class AntelopeEntityManager extends AbstractEntityManager implements
    AntelopeEntityManagerInterface
{
    public function createAntelope(AntelopeTransfer $antelopeTransfer): AntelopeTransfer
    {
        $antelopeEntity = new PyzAntelope();
        $antelopeEntity->fromArray($antelopeTransfer->modifiedToArray());
        $antelopeEntity->save();

        return $antelopeTransfer->fromArray($antelopeEntity->toArray(), true);
    }

    public function createAntelopeLocation(
        AntelopeLocationTransfer $antelopeLocationTransfer,
    ): AntelopeLocationTransfer {
        $antelopeEntity = new PyzAntelopeLocation();

        $antelopeEntity->fromArray($antelopeLocationTransfer->modifiedToArray());
        $antelopeEntity->save();

        $mapper = $this->getFactory()->createAntelopeLocationMapper();

        return $mapper->mapAntelopeLocationEntityToTransfer(
            $antelopeEntity,
            $antelopeLocationTransfer
        );
    }

    public function updateAntelopeLocation(
        AntelopeLocationTransfer $antelopeLocationTransfer,
    ): AntelopeLocationTransfer {

        $antelopeLocationId = $antelopeLocationTransfer->getIdAntelopeLocation();
        $antelopeEntity = $this->getFactory()
            ->createAntelopeLocationQuery()
            ->filterByIdLocation($antelopeLocationId)->findOne();
        if (!$antelopeEntity) {
            throw new EntityNotFoundException("Antelope location with id $antelopeLocationId was not found", 404);
        }
        $mapper = $this->getFactory()->createAntelopeLocationMapper();
        $antelopeLocationEntity = $mapper->mapAntelopeLocationTransferToEntity(
            $antelopeLocationTransfer,
            $antelopeEntity
        );
        $antelopeLocationEntity->save();
        return $mapper->mapAntelopeLocationEntityToTransfer(
            $antelopeEntity,
            $antelopeLocationTransfer
        );
    }

    public function deleteAntelopeLocation(
        AntelopeLocationTransfer $antelopeLocationTransfer,
    ): bool
    {
        $antelopeLocationEntity = $this->getFactory()
            ->createAntelopeLocationMapper()
            ->mapAntelopeLocationTransferToEntity(
                $antelopeLocationTransfer,
                new PyzAntelopeLocation()
            );
        $antelopeLocationEntity->delete();
        return $antelopeLocationEntity->isDeleted();
    }
}
