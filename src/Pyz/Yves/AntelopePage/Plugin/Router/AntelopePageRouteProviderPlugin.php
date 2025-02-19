<?php

namespace Pyz\Yves\AntelopePage\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class AntelopePageRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    public const string ROUTE_NAME_ANTELOPE_NAME = '/antelope/_name_';
    public const string ROUTE_NAME_ANTELOPES = '/antelopes';

    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addAntelopeByNameGetRoute($routeCollection);
        $routeCollection = $this->addAntelopeCollectionGetRoute($routeCollection);
        return $routeCollection;
    }

    private function addAntelopeByNameGetRoute(
        RouteCollection $routeCollection
    ): RouteCollection {
        $route = $this->buildRoute('/antelope/{name}', 'AntelopePage',
            'Antelope', 'getAction');
        $route = $route->setMethods(['GET']);
        $routeCollection->add(static::ROUTE_NAME_ANTELOPE_NAME,
            $route);

        return $routeCollection;
    }

    private function addAntelopeCollectionGetRoute(
        RouteCollection $routeCollection
    ): RouteCollection {
        $route = $this->buildRoute('/antelopes', 'AntelopePage',
            'Antelopes', 'getAction');
        $route = $route->setMethods(['GET']);
        $routeCollection->add(static::ROUTE_NAME_ANTELOPES,
            $route);

        return $routeCollection;
    }
}
