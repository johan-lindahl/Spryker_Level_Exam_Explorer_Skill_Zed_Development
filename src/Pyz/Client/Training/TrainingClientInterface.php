<?php
declare(strict_types=1);

namespace Pyz\Client\Training;

use Generated\Shared\Transfer\AntelopeCriteriaTransfer;
use Generated\Shared\Transfer\AntelopeResponseTransfer;

interface TrainingClientInterface
{
    public function getAntelope(AntelopeCriteriaTransfer $antelopeCriteria): AntelopeResponseTransfer;
}