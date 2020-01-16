<?php

namespace App\Controllers;

use App\Models\User;
use Src\App;
use Src\Configs\TwigExtension;
use Src\Services\Auth\Auth;
use Src\Services\Validation\Validator;
use Twig\Environment;
use Twig\Extension\DebugExtension;

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

    public function __construct()
    {
        // Init Twig
        $this->twig = new Environment(App::getTwigLoader(), ['debug' => true]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new TwigExtension());

        $this->auth = new Auth();
        $this->user = Auth::getUserByAuthToken();
        $this->validator = new Validator();
    }
}