<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Deleter;

use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

interface AntelopeLocationDeleterInterface
{
    public function deleteAntelopeLocation(GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer;
}
