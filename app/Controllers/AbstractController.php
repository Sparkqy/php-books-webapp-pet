<?php

namespace App\Controllers;

use Src\App;
use Src\Configs\TwigExtension;
use Twig\Environment;
use Twig\Extension\DebugExtension;

abstract class AbstractController
{
    /**
     * @var Environment
     */
    protected $twig;

    public function __construct()
    {
        $this->twig = new Environment(App::getTwigLoader(), ['debug' => true]);
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new TwigExtension());
    }
}