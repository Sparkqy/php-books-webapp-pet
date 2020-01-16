<?php

namespace App\Controllers\Admin;

use App\Controllers\AbstractController;
use Src\Helpers\Router;

abstract class AdminAbstractController extends AbstractController
{
    /**
     * @var string
     */
    private $redirectToLogin = '/login';

    public function __construct()
    {
        parent::__construct();

        if ($this->user === null) {
            Router::redirect($this->redirectToLogin);
        }
    }
}