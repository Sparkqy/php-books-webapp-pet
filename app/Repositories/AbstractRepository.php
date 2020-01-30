<?php

namespace App\Repositories;

use Src\Core\DI\DI;

abstract class AbstractRepository
{
    /**
     * @var DI
     */
    protected DI $di;

    /**
     * @var array
     */
    protected array $sortOrders = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    /**
     * AbstractRepository constructor.
     * @param DI $di
     */
    public function __construct(DI $di)
    {
        $this->di = $di;
    }
}