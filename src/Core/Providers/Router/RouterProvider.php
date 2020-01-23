<?php

namespace Src\Core\Providers\Router;

use Src\Core\Providers\AbstractServiceProvider;
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