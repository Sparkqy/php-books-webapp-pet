<?php

namespace Src\Core\ServiceProviders;

use Src\Core\DI\DI;

abstract class AbstractServiceProvider
{
    /**
     * @var DI
     */
    protected DI $di;

    /**
     * AbstractServiceProvider constructor.
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
    }

    /**
     * @return void
     */
    abstract public function init(): void;
}