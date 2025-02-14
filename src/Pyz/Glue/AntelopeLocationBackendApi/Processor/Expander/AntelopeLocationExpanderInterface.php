<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Expander;

use Generated\Shared\Transfer\AntelopeLocationConditionTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;

interface AntelopeLocationExpanderInterface
{
    public function expandWithFilters(
        AntelopeLocationConditionTransfer $antelopeLocationConditionTransfer,
        GlueRequestTransfer $glueRequestTransfer,
    ): AntelopeLocationConditionTransfer;
}
