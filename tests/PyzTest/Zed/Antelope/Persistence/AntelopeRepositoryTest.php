<?php

namespace PyzTest\Zed\Antelope\Persistence;

use Codeception\Test\Unit;
use Pyz\Zed\Antelope\Persistence\AntelopeRepository;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Generated\Shared\Transfer\AntelopeCriteriaTransfer;

/**
 * @group Antelope
 */
class AntelopeRepositoryTest extends Unit
{

    protected AntelopeRepository $repository;

    public function testGetAntelopeLocationByIdThrowsExceptionWhenNotFound(): void
    {
        $nonExistentId = 99999;

        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage(sprintf('Antelope Location %d not found', $nonExistentId));

        $this->repository->getAntelopeLocationById($nonExistentId);
    }

    public function testGetAntelopeByName(): void
    {
        $antelopeCriteriaTransfer = new AntelopeCriteriaTransfer();
        $antelopeCriteriaTransfer->setName('TEST-1738584764');
        $antelopeDTO = $this->repository->getAntelope($antelopeCriteriaTransfer);
    }

    public function testGetAntelopeLocationById(): void
    {
        $existentId = 8;
        $antelopeLocationDTO = $this->repository->getAntelopeLocationById($existentId);
    }

    protected function _before(): void
    {
        $this->repository = new AntelopeRepository();
    }
}
