<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;

interface AntelopeLocationMapperInterface
{
    public function mapAntelopeLocationBackendApiAttributesToAntelopeLocationTransfer(
        AntelopeLocationBackendApiAttributesTransfer $antelopesBackendApiAttributesTransfer,
        AntelopeLocationTransfer $antelopeTransfer
    ): AntelopeLocationTransfer;
}
