<?php

namespace PyzTest\Zed\Antelope\Persistence;

use Codeception\Test\Unit;
use Pyz\Zed\Antelope\Persistence\AntelopeEntityManager;
use Generated\Shared\Transfer\AntelopeTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;

/**
 * @group Antelope
 */
class AntelopeEntityManagerTest extends Unit
{

    protected AntelopeEntityManager $entityManager;

    public function testCreateAntelope(): void
    {
        $antelopeLocationDTO = new AntelopeLocationTransfer();
        $antelopeLocationDTO->setLocationName("TEST-location" . time());
        $antelopeLocationDTO = $this->entityManager->createLocation($antelopeLocationDTO);

        $antelopeDTO = new AntelopeTransfer();
        $antelopeDTO->setName('TEST-' . time());
        $antelopeDTO->setLocation($antelopeLocationDTO);
        $antelopeDTO = $this->entityManager->createAntelope($antelopeDTO);
    }

    protected function _before(): void
    {
        $this->entityManager = new AntelopeEntityManager();
    }
}
