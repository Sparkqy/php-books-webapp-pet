<?php

namespace App\Controllers\Auth;

use App\Controllers\AbstractController;
use Src\Core\DI\DI;
use src\Exceptions\DIContainerException;
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
     * @param DI $di
     * @throws FileNotFoundException
     * @throws DIContainerException
     */
    public function __construct(DI $di)
    {
        parent::__construct($di);

        if ($this->user === null) {
            throw new FileNotFoundException('Page not found');
        }
    }

    public function logout(): void
    {
        $this->auth->unAuthorize();

        Router::redirect($this->redirectAfterLogout);
    }
}