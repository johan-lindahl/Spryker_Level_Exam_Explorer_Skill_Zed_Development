<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Updater;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

interface AntelopeLocationUpdaterInterface
{
    public function updateAntelopeLocation(
        AntelopeLocationBackendApiAttributesTransfer $antelopesBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer;
}
