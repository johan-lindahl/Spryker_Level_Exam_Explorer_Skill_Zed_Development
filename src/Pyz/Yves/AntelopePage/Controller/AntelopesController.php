<?php

namespace Pyz\Yves\AntelopePage\Controller;

use Generated\Shared\Transfer\AntelopeCriteriaTransfer;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\ShopApplication\Controller\AbstractController;

/**
 * @method \Pyz\Yves\AntelopePage\AntelopePageFactory getFactory()
 */
class AntelopesController extends AbstractController
{
    public function getAction(): View
    {
        $antelopeCriteriaTransfer = new AntelopeCriteriaTransfer();

        $antelopeResponseTransfer = $this->getFactory()
            ->getAntelopeClient()
            ->getAntelopeCollection($antelopeCriteriaTransfer);

        return $this->view(
            ['antelopes' => $antelopeResponseTransfer->getAntelopes()],
            [],
            '@AntelopePage/views/antelope/index.twig'
        );
    }
}
