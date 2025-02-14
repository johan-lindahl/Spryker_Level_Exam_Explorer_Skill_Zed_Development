<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Deleter;

use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapperInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Symfony\Component\HttpFoundation\Response;

class AntelopeLocationDeleter implements AntelopeLocationDeleterInterface
{
    /**
     * @param AntelopeFacadeInterface $getAntelopeFacade
     * @param AntelopeResponseBuilderInterface $createAntelopeResponseBuilder
     * @param AntelopeMapperInterface $createAntelopeMapper
     */
    public function __construct(
        protected readonly AntelopeFacadeInterface $antelopeFacade,
        protected readonly AntelopeLocationResponseBuilderInterface $antelopeResponseBuilder,
        protected readonly AntelopeLocationMapperInterface $antelopeMapper
    ) {
    }

    public function deleteAntelopeLocation(GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        try
        {
            $resourceId = (int)$glueRequestTransfer->getResource()?->getId();
            $antelopeLocationTransfer = (new AntelopeLocationTransfer())->setIdAntelopeLocation($resourceId);
            if (!$this->antelopeFacade->deleteAntelopeLocation($antelopeLocationTransfer))
            {
                throw new \Exception("Antelope location with id $resourceId could not be deleted", Response::HTTP_BAD_REQUEST);
            }
            return $this->antelopeResponseBuilder->createAntelopeLocationResponse(new AntelopeLocationCollectionTransfer());    
        }
        catch (\Exception $e)
        {
            return $this->antelopeResponseBuilder->createErrorResponse($e);
        }
    }
}
