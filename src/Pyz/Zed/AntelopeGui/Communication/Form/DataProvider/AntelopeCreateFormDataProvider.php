<?php

namespace Pyz\Zed\AntelopeGui\Communication\Form\DataProvider;

use Pyz\Zed\AntelopeGui\Communication\Form\AntelopeCreateForm;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;

class AntelopeCreateFormDataProvider
{
    public function __construct(
        protected AntelopeFacadeInterface $antelopeFacade
        )
    {
    }

    public function getOptions()
    {
        return [
            AntelopeCreateForm::FIELD_LOCATION => $this->createLocationList(),
        ];
    }

    protected function createLocationList()
    {
        $locationCollection = $this->antelopeFacade->getAntelopeLocations();
        return $locationCollection->getLocations();
    }
}
