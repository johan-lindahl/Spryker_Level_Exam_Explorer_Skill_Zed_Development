<?php

namespace Pyz\Zed\Antelope\Communication\Controller;

use Faker\Factory as FakerFactory;
use Generated\Shared\Transfer\AntelopeLocationTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Antelope\Business\AntelopeFacadeInterface getFacade()
 */
class AntelopeLocationController extends AbstractController
{
    /**
     * @param Request $request
     * @return array<string,mixed>
     */
    public function addAction(Request $request): array
    {
        $antelopeLocationTransfer = new AntelopeLocationTransfer();
        $name = $request->get('name');
        if (!$name) {
            $name = FakerFactory::create()->name() ;
        }
        $antelopeLocationTransfer->setLocationName($name);
        $this->getFacade()->createAntelopeLocation($antelopeLocationTransfer);
        return $this->viewResponse(['antelopeLocation' => $antelopeLocationTransfer]);
    }
}
