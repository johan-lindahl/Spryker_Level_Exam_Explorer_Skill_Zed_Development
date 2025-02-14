<?php

namespace Pyz\Glue\AntelopeLocationBackendApi\Plugin;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\GlueResourceMethodCollectionTransfer;
use Generated\Shared\Transfer\GlueResourceMethodConfigurationTransfer;
use Pyz\Glue\AntelopeLocationBackendApi\AntelopeLocationBackendApiConfig;
use Spryker\Glue\GlueApplication\Plugin\GlueApplication\Backend\AbstractResourcePlugin;
use Spryker\Glue\GlueJsonApiConventionExtension\Dependency\Plugin\JsonApiResourceInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Controller\AntelopeLocationResourceController;

class AntelopeLocationBackendApiResourcePlugin extends AbstractResourcePlugin implements JsonApiResourceInterface
{
    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return AntelopeLocationBackendApiConfig::RESOURCE_ANTELOPE_LOCATION;
    }

    /**
     * @inheritDoc
     */
    public function getController(): string
    {
        return AntelopeLocationResourceController::class;
    }

    /**
     * @inheritDoc
     */
    public function getDeclaredMethods(): GlueResourceMethodCollectionTransfer
    {
        $collection = new GlueResourceMethodCollectionTransfer();

        $collection->setGetCollection(
            (new GlueResourceMethodConfigurationTransfer)->setAttributes(AntelopeLocationBackendApiAttributesTransfer::class)
        )->setGet(
            (new GlueResourceMethodConfigurationTransfer)->setAttributes(AntelopeLocationBackendApiAttributesTransfer::class)
        )->setPost(
            (new GlueResourceMethodConfigurationTransfer)->setAttributes(AntelopeLocationBackendApiAttributesTransfer::class)
        )->setPut(
            (new GlueResourceMethodConfigurationTransfer)->setAttributes(AntelopeLocationBackendApiAttributesTransfer::class)
        )->setDelete(
            (new GlueResourceMethodConfigurationTransfer)
        );

        return $collection;
    }
}
