<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\ImageSearchAi\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;

class ImageSearchAiRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    /**
     * @var string
     */
    protected const ROUTE_IMAGE_SEARCH = 'search-ai/image';

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = $this->addImageSearchRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addImageSearchRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute(
            '/search-ai/image',
            'ImageSearchAi',
            'ImageSearch',
            'findTermsAction',
        )->setMethods(Request::METHOD_POST);

        $routeCollection->add(static::ROUTE_IMAGE_SEARCH, $route);

        return $routeCollection;
    }
}
