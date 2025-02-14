<?php

namespace Pyz\Glue\AntelopeLocationBackendApi;

use Spryker\Glue\Kernel\Backend\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Backend\Container;

class AntelopeLocationBackendApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_ANTELOPE = 'FACADE_ANTELOPE';

    public function provideBackendDependencies(Container $container): Container
    {
        $container = parent::provideBackendDependencies($container);
        $container = $this->addAntelopeFacade($container);

        return $container;
    }

    protected function addAntelopeFacade(Container $container): Container
    {
        $container->set(static::FACADE_ANTELOPE, function (Container $container) {
            return $container->getLocator()->antelope()->facade();
        });

        return $container;
    }
}
