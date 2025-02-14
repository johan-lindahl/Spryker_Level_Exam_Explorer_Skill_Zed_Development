<?php

declare(strict_types=1);

namespace Pyz\Zed\Antelope\Business\AntelopeLocation\Updater;

use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Pyz\Zed\Antelope\Persistence\AntelopeEntityManagerInterface;

class AntelopeLocationUpdater
{
    public function __construct(
        protected AntelopeEntityManagerInterface $antelopeEntityManager
    ) {
    }

    public function updateAntelopeLocation(AntelopeLocationTransfer $antelopeLocationTransfer
    ): AntelopeLocationTransfer {
        return $this->antelopeEntityManager->updateAntelopeLocation($antelopeLocationTransfer);
    }
}
