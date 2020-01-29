<?php

namespace Src\Core\ServiceProviders\Router;

use Src\Core\ServiceProviders\AbstractServiceProvider;
use Src\Core\Router\Router;
use src\Exceptions\DIContainerException;

class RouterProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    const SERVICE_NAME = 'router';

    /**
     * @throws DIContainerException
     */
    public function init(): void
    {
        $router = new Router();
        $this->di->set(self::SERVICE_NAME, $router);
    }
}