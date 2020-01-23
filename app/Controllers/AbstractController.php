<?php

namespace App\Controllers;

use App\Models\User;
use Src\Core\DI\DI;
use src\Exceptions\DIContainerException;
use Src\Services\Auth\Auth;
use Src\Services\Validation\Validator;
use Twig\Environment;

abstract class AbstractController
{
    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @var User|null
     */
    protected $user;

    /**
     * @var Validator
     */
    protected $validator;

    /**
     * AbstractController constructor.
     * @param DI $di
     * @throws DIContainerException
     */
    public function __construct(DI $di)
    {
        $this->twig = $di->get('twig');
        $this->auth = $di->get('auth');
        $this->user = Auth::getUserByAuthToken();
        $this->validator = $di->get('validator');
    }
}