<?php

namespace App\Controllers\Admin;

use App\Controllers\AbstractController;
use Src\Core\DI\DI;
use Src\Helpers\Router;

abstract class AdminAbstractController extends AbstractController
{
    /**
     * @var string
     */
    private string $redirectToLogin = '/login';

    public function __construct(DI $di)
    {
        parent::__construct($di);

        if ($this->user === null) {
            Router::redirect($this->redirectToLogin);
        }
    }
}