<?php

namespace Src\Core\Router;

use ReflectionException;
use Src\Exceptions\FileNotFoundException;
use Src\Exceptions\MethodNotFoundException;
use Src\Exceptions\InappropriateTypeException;
use Src\Exceptions\WrongRequestMethodException;

class Router
{
    /**
     * @var UrlDispatcher
     */
    protected $urlDispatcher;

    public function __construct()
    {
        $this->urlDispatcher = new UrlDispatcher();
    }

    /**
     * @return DispatchedRoute
     * @throws FileNotFoundException
     * @throws InappropriateTypeException
     * @throws WrongRequestMethodException
     * @throws ReflectionException
     * @throws MethodNotFoundException
     */
    public function dispatch(): DispatchedRoute
    {
        return $this->urlDispatcher->dispatch();
    }
}