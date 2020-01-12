<?php

namespace Src;

use http\Exception\InvalidArgumentException;
use Src\Core\Database\Migration\Migration;
use Src\Core\Router\Router;
use Twig\Loader\FilesystemLoader;

class App
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var FilesystemLoader
     */
    protected static $twigLoader;

    public function __construct()
    {
        Migration::initStatically();
        self::initTwigLoader();
        $this->router = new Router();
    }

    /**
     * @return FilesystemLoader
     */
    private static function initTwigLoader(): FilesystemLoader
    {
        if (self::$twigLoader === null) {
            self::$twigLoader = new FilesystemLoader(VIEWS_PATH);
        }

        return self::$twigLoader;
    }

    /**
     * @return FilesystemLoader
     */
    public static function getTwigLoader(): FilesystemLoader
    {
        return self::$twigLoader;
    }

    public function run()
    {
        try {
            $dispatchedRoute = $this->router->dispatch();
            $controller = $dispatchedRoute->getController();

            call_user_func_array([new $controller(), $dispatchedRoute->getAction()], $dispatchedRoute->getParams());
        } catch (
            Exceptions\FileNotFoundException | Exceptions\InappropriateTypeException | InvalidArgumentException |
            Exceptions\WrongRequestMethodException | \ReflectionException | Exceptions\MethodNotFoundException $e
        ) {
            echo $e->getMessage();
            exit();
        }
    }
}