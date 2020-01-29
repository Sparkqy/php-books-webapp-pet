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
    protected Environment $twig;

    /**
     * @var Auth
     */
    protected Auth $auth;

    /**
     * @var User|null
     */
    protected ?User $user;

    /**
     * @var Validator
     */
    protected Validator $validator;

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