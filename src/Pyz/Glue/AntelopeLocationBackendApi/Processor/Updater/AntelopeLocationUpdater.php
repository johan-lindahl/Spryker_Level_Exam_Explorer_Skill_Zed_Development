<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Updater;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapperInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;

class AntelopeLocationUpdater implements AntelopeLocationUpdaterInterface
{
    public function __construct(
        protected AntelopeFacadeInterface $antelopeFacade,
        protected readonly AntelopeLocationResponseBuilderInterface $antelopeResponseBuilder,
        protected readonly AntelopeLocationMapperInterface $antelopeLocationMapper
    ) {
    }

    public function updateAntelopeLocation(
        AntelopeLocationBackendApiAttributesTransfer $antelopeLocationBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        $antelopeTransfer = $this->antelopeLocationMapper->mapAntelopeLocationBackendApiAttributesToAntelopeLocationTransfer(
            $antelopeLocationBackendApiAttributesTransfer,
            new AntelopeLocationTransfer());

        try {
            $antelopeLocationTransfer = $this->antelopeFacade->updateAntelopeLocation($antelopeTransfer);
        }
        catch(\Exception $e) {
            return $this->antelopeResponseBuilder->createErrorResponse($e);
        }
        $antelopeLocationCollectionTransfer = (new AntelopeLocationCollectionTransfer())->addAntelopeLocation($antelopeLocationTransfer);
        return $this->antelopeResponseBuilder->createAntelopeLocationResponse($antelopeLocationCollectionTransfer);
    }
}
