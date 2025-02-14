<?php

namespace Pyz\Glue\AntelopeLocationBackendApi;

use Pyz\Glue\AntelopeLocationBackendApi\Processor\Creator\AntelopeLocationCreator;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Deleter\AntelopeLocationDeleter;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Expander\AntelopeLocationExpander;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Expander\AntelopeLocationExpanderInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapper;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Mapper\AntelopeLocationMapperInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Reader\AntelopeLocationReader;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Reader\AntelopeLocationReaderInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilder;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\ResponseBuilder\AntelopeLocationResponseBuilderInterface;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Updater\AntelopeLocationUpdater;
use Pyz\Glue\AntelopeLocationBackendApi\Processor\Updater\AntelopeLocationUpdaterInterface;
use Pyz\Zed\Antelope\Business\AntelopeFacadeInterface;
use Spryker\Glue\Kernel\Backend\AbstractFactory;

class AntelopeLocationBackendApiFactory extends AbstractFactory
{
    public function createAntelopeLocationReader(): AntelopeLocationReaderInterface
    {
        return new AntelopeLocationReader(
            $this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
            $this->createAntelopeLocationExpander(),
        );
    }

    public function getAntelopeFacade(): AntelopeFacadeInterface
    {
        return $this->getProvidedDependency(AntelopeLocationBackendApiDependencyProvider::FACADE_ANTELOPE);
    }

    public function createAntelopeLocationResponseBuilder(
    ): AntelopeLocationResponseBuilderInterface
    {
        return new AntelopeLocationResponseBuilder();
    }

    public function createAntelopeLocationExpander(): AntelopeLocationExpanderInterface
    {
        return new AntelopeLocationExpander();
    }

    public function createAntelopeLocationWriter(): AntelopeLocationCreator
    {
        return new AntelopeLocationCreator(
            $this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
            $this->createAntelopeLocationMapper()
        );
    }

    public function createAntelopeLocationMapper(): AntelopeLocationMapperInterface
    {
        return new AntelopeLocationMapper();
    }

    public function createAntelopeLocationUpdater(): AntelopeLocationUpdaterInterface
    {
        return new AntelopeLocationUpdater($this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
            $this->createAntelopeLocationMapper());
    }

    public function createAntelopeLocationDeleter()
    {
        return new AntelopeLocationDeleter($this->getAntelopeFacade(),
            $this->createAntelopeLocationResponseBuilder(),
            $this->createAntelopeLocationMapper());
    }
}
