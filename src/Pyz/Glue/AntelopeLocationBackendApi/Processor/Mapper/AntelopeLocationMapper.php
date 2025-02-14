<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;

class AntelopeLocationMapper implements AntelopeLocationMapperInterface
{

    public function mapAntelopeLocationBackendApiAttributesToAntelopeLocationTransfer(
        AntelopeLocationBackendApiAttributesTransfer $antelopeLocaiotnBackendApiAttributesTransfer,
        AntelopeLocationTransfer $antelopeLocationTransfer
    ): AntelopeLocationTransfer {
        return $antelopeLocationTransfer->fromArray($antelopeLocaiotnBackendApiAttributesTransfer->toArray(),
            true);
    }
}
