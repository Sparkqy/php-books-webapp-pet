<?php

namespace App\Controllers\Auth;

use App\Controllers\AbstractController;
use Src\Exceptions\FileNotFoundException;
use Src\Helpers\Router;

class LogoutController extends AbstractController
{
    /**
     * @var string
     */
    protected $redirectAfterLogout = '/';

    /**
     * LogoutController constructor.
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct();

        if (!$this->auth->isAuthorized()) {
            throw new FileNotFoundException('Page not found');
        }
    }

    public function logout(): void
    {
        $this->auth->unAuthorize();

        Router::redirect($this->redirectAfterLogout);
    }
}