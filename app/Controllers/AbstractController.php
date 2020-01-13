<?php

namespace App\Controllers;

use Src\App;
use Src\Configs\TwigExtension;
use Src\Services\Auth\Auth;
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

    public function __construct()
    {
        $this->twig = new Environment(App::getTwigLoader(), ['debug' => true]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new TwigExtension());

        $this->auth = new Auth();
    }
}