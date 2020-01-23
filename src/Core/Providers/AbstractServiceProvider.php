<?php

namespace Src\Core\Providers;

use Src\Core\DI\DI;

abstract class AbstractServiceProvider
{
    /**
     * @var DI
     */
    protected $di;

    /**
     * AbstractServiceProvider constructor.
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
    }

    abstract public function init(): void;
}