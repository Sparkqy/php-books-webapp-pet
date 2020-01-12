<?php

namespace Src\Core\Router;

use App\Controllers\AbstractController;

class DispatchedRoute
{
    /**
     * @var string
     */
    protected $controller;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var array
     */
    protected $params;

    /**
     * DispatchedRoute constructor.
     * @param array $dispatchedRoute
     * @param array $params
     */
    public function __construct(array $dispatchedRoute, array $params)
    {
        $this->controller = $dispatchedRoute[1];
        $this->action = $dispatchedRoute[2];
        $this->params = $params;
    }

    /**
     * @return AbstractController
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}