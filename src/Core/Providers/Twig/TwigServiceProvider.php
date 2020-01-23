<?php

namespace Src\Core\Providers\Twig;

use Src\Configs\TwigExtension;
use Src\Core\Providers\AbstractServiceProvider;
use src\Exceptions\DIContainerException;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

class TwigServiceProvider extends AbstractServiceProvider
{
    /**
     * @var string
     */
    const SERVICE_NAME = 'twig';

    /**
     * @throws DIContainerException
     */
    public function init(): void
    {
        $twigLoader = new FilesystemLoader(VIEWS_PATH);
        $twig = new Environment($twigLoader, ['debug' => true]);
        $twig->addExtension(new DebugExtension());
        $twig->addExtension(new TwigExtension());

        $this->di->set(self::SERVICE_NAME, $twig);
    }
}