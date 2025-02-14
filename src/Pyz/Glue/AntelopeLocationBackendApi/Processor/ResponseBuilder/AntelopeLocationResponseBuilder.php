<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder;

use ArrayObject;
use Exception;
use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\AntelopeLocationCollectionTransfer;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Generated\Shared\Transfer\GlueErrorTransfer;
use Generated\Shared\Transfer\GlueResourceTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\AntelopeLocationBackendApiConfig;

class AntelopeLocationResponseBuilder implements AntelopeLocationResponseBuilderInterface
{
    public function createAntelopeLocationResponse(AntelopeLocationCollectionTransfer $antelopeLocationCollectionTransfer): GlueResponseTransfer
    {
        $responseTransfer = new GlueResponseTransfer();
        foreach ($antelopeLocationCollectionTransfer->getAntelopeLocations() as $antelopeLocation) {
            $resource = $this->mapAntelopeLocationDtoToGlueResourceTransfer($antelopeLocation);
            $responseTransfer->addResource($resource);
        }
        $responseTransfer->setPagination($antelopeLocationCollectionTransfer->getPagination());

        return $responseTransfer;
    }

    protected function mapAntelopeLocationDtoToGlueResourceTransfer(AntelopeLocationTransfer $antelopeLocationTransfer): GlueResourceTransfer
    {
        $resource = new GlueResourceTransfer();
        $resource->setType(AntelopeLocationBackendApiConfig::RESOURCE_ANTELOPE_LOCATION);
        $resource->setId('' . $antelopeLocationTransfer->getIdAntelopeLocation());
        $attributes = new AntelopeLocationBackendApiAttributesTransfer();
        $attributes->fromArray($antelopeLocationTransfer->toArray(), true);
        $resource->setAttributes($attributes);

        return $resource;
    }

    public function createErrorResponse(Exception $exception): GlueResponseTransfer
    { 
        $responseTransfer = new GlueResponseTransfer();
        $error = new GlueErrorTransfer();
        $error->setMessage($exception->getMessage());
        $error->setCode($exception->getCode()?:500);
        $responseTransfer->setErrors(new ArrayObject ([$error]));
        $responseTransfer->setHttpStatus($exception->getCode()?:500);
        return $responseTransfer;
    }

}
