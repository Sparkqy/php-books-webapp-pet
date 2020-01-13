<?php

namespace App\Controllers\Admin;

use App\Controllers\AbstractController;
use Src\Helpers\Router;

abstract class AdminAbstractController extends AbstractController
{
    /**
     * @var string
     */
    private $redirectLogin = '/login';

    public function __construct()
    {
        parent::__construct();

        if (!$this->auth->isAuthorized()) {
            Router::redirect($this->redirectLogin);
        }
    }
}