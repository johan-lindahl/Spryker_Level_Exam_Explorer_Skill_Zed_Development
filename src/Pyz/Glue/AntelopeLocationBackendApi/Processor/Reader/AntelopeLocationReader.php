<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\Reader;

use Generated\Shared\Transfer\AntelopeLocationConditionTransfer;
use Generated\Shared\Transfer\AntelopeLocationCriteriaTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Expander\AntelopeLocationExpanderInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Pyz\Zed\Antelope\Persistence\Exception\EntityNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AntelopeLocationReader implements AntelopeLocationReaderInterface
{
    public function __construct(
        private readonly AntelopeFacadeInterface $antelopeFacade,
        private readonly AntelopeLocationResponseBuilderInterface $antelopeLocationResponseBuilder,
        private readonly AntelopeLocationExpanderInterface $antelopesLocationExpander,
    ) {
    }

    public function getAntelopeLocation(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        $antelopeLocationCriteriaTransfer = new AntelopeLocationCriteriaTransfer();
        $conditions = new AntelopeLocationConditionTransfer();
        $resourceId = (int)$glueRequestTransfer->getResource()?->getId();
        $conditions->setIdAntelopeLocation($resourceId);
        $antelopeLocationCriteriaTransfer->setAntelopeLocationConditions($conditions);

        try {
            $antelopeLocationCollectionTransfer = $this->antelopeFacade
                ->getAntelopeLocationCollection($antelopeLocationCriteriaTransfer);
            if ($antelopeLocationCollectionTransfer->getAntelopeLocations()->count() === 0) {
                throw new EntityNotFoundException("Antelope location with id $resourceId was not found", Response::HTTP_NOT_FOUND);
            }
            return $this->antelopeLocationResponseBuilder->createAntelopeLocationResponse($antelopeLocationCollectionTransfer);
        } catch (\Exception $e) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse($e);
        }
    }

    public function getAntelopeLocationCollection(
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        $antelopeLocationCriteriaTransfer = new AntelopeLocationCriteriaTransfer();
        $conditions = new AntelopeLocationConditionTransfer();
        $this->antelopesLocationExpander->expandWithFilters(
            $conditions,
            $glueRequestTransfer
        );
        $antelopeLocationCriteriaTransfer->setPagination($glueRequestTransfer->getPagination())
            ->setSortCollection($glueRequestTransfer->getSortings())
            ->setAntelopeLocationConditions($conditions);
        return $this->getAntelopeLocationCollectionTransfer($antelopeLocationCriteriaTransfer);
    }

    /**
     * @param AntelopeLocationCriteriaTransfer $antelopeLocationCriteriaTransfer
     * @return GlueResponseTransfer
     */
    private function getAntelopeLocationCollectionTransfer(
        AntelopeLocationCriteriaTransfer $antelopeLocationCriteriaTransfer
    ): GlueResponseTransfer {

        try {
            $antelopeLocationCollectionTransfer = $this->antelopeFacade
                ->getAntelopeLocationCollection($antelopeLocationCriteriaTransfer);
            return $this->antelopeLocationResponseBuilder->createAntelopeLocationResponse($antelopeLocationCollectionTransfer);
        } catch (\Exception $e) {
            return $this->antelopeLocationResponseBuilder->createErrorResponse($e);
        }
    }
}
