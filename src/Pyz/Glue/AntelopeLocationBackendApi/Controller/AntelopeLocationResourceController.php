<?php

declare(strict_types=1);

namespace Pyz\Glue\AntelopeLocationBackendApi\Controller;

use Generated\Shared\Transfer\AntelopeLocationBackendApiAttributesTransfer;
use Generated\Shared\Transfer\GlueRequestTransfer;
use Generated\Shared\Transfer\GlueResponseTransfer;
use Spryker\Glue\Kernel\Backend\Controller\AbstractController;

/**
 * @method \Pyz\Glue\AntelopesBackendApi\AntelopeLocationBackendApiFactory getFactory()
 */
class AntelopeLocationResourceController extends AbstractController
{
    public function getCollectionAction(GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        return $this->getFactory()->createAntelopeLocationReader()->getAntelopeLocationCollection($glueRequestTransfer);
    }

    public function getAction(GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        return $this->getFactory()->createAntelopeLocationReader()->getAntelopeLocation($glueRequestTransfer);
    }

    public function postAction(
        AntelopeLocationBackendApiAttributesTransfer $antelopesBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        return $this->getFactory()->createAntelopeLocationWriter()->createAntelopeLocation($antelopesBackendApiAttributesTransfer,
            $glueRequestTransfer);
    }

    public function putAction(
        AntelopeLocationBackendApiAttributesTransfer $antelopeLocationBackendApiAttributesTransfer,
        GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        $antelopeLocationBackendApiAttributesTransfer->setIdAntelopeLocation((int)$glueRequestTransfer->getResource()?->getId());
        return $this->getFactory()->createAntelopeLocationUpdater()->updateAntelopeLocation($antelopeLocationBackendApiAttributesTransfer,
            $glueRequestTransfer);
    }

    public function deleteAction(GlueRequestTransfer $glueRequestTransfer
    ): GlueResponseTransfer {
        return $this->getFactory()->createAntelopeLocationDeleter()->deleteAntelopeLocation($glueRequestTransfer);
    }
}
