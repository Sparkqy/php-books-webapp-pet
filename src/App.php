<?php

namespace Src;

use http\Exception\InvalidArgumentException;
use Src\Core\Database\Migration\Migration;
use Src\Core\DI\DI;
use Src\Core\Providers\Router\RouterProvider;
use Src\Core\Router\Router;
use Src\Exceptions\DIContainerException;

class App
{
    /**
     * @var DI
     */
    private $di;

    /**
     * @var Router
     */
    protected $router;

    /**
     * App constructor.
     * @param DI $di
     * @throws DIContainerException
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
        $this->router = $this->di->get(RouterProvider::SERVICE_NAME);
        Migration::initStatically();
    }

    public function run(): void
    {
        try {
            $dispatchedRoute = $this->router->dispatch();
            $controller = $dispatchedRoute->getController();

            call_user_func_array([new $controller($this->di), $dispatchedRoute->getAction()], $dispatchedRoute->getParams());
        } catch (
            Exceptions\FileNotFoundException | Exceptions\InappropriateTypeException | InvalidArgumentException |
            Exceptions\WrongRequestMethodException | \ReflectionException | Exceptions\MethodNotFoundException $e
        ) {
            http_response_code(404);
            echo $e->getMessage();
            exit();
        }
    }
}