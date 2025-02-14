<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder;

use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;

interface AntelopeLocationResponseBuilderInterface
{
    public function createAntelopeLocationResponse(AntelopeLocationCollectionTransfer $antelopeLocationCollectionTransfer): GlueResponseTransfer;
    public function createErrorResponse(\Exception $exception): GlueResponseTransfer;
}
