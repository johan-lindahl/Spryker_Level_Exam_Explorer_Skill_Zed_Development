<?php

namespace Pyz\Zed\Antelope\Business\AntelopeLocation\Reader;

use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Pyz\Zed\Antelope\Persistence\AntelopeRepositoryInterface;

class AntelopeLocationReader
{
    public function __construct(
        protected AntelopeRepositoryInterface $antelopeRepository
    ) {
    }

    public function getAntelopeLocationById(
        int $antelopeLocationId
    ): AntelopeLocationTransfer {
        $antelopeLocationTransfer = $this->antelopeRepository->getAntelopeLocationById($antelopeLocationId);
        return $antelopeLocationTransfer;
    }
}
