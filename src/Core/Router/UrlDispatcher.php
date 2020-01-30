<?php

namespace Src\Core\Router;

use App\Controllers\AbstractController;
use Src\Exceptions\FileNotFoundException;
use Src\Exceptions\MethodNotFoundException;
use Src\Exceptions\InappropriateTypeException;
use Src\Exceptions\WrongRequestMethodException;
use Src\Helpers\Url;
use Src\Helpers\Router as RouterHelper;

class UrlDispatcher
{
    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $requestMethod;

    /**
     * @var array
     */
    protected array $routes = [];

    /**
     * @var null|array
     */
    protected ?array $matchedRoute = null;

    public function __construct()
    {
        $this->url = Url::getUrl();
        $this->requestMethod = Url::getRequestMethod();
        try {
            $this->routes = RouterHelper::getRoutes(ROOT . '/../routes/web.php');
        } catch (FileNotFoundException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    /**
     * @return DispatchedRoute
     * @throws FileNotFoundException
     * @throws MethodNotFoundException
     * @throws InappropriateTypeException
     * @throws WrongRequestMethodException
     * @throws \ReflectionException
     */
    public function dispatch(): DispatchedRoute
    {
        if ($this->routes !== null) {
            foreach ($this->routes as $pattern => $route) {
                preg_match($pattern, $this->url, $matches);

                if (!empty($matches)) {
                    if ($route[0] !== $this->requestMethod) {
                        throw new WrongRequestMethodException('Server request method does not match route method');
                    }

                    $reflect = new \ReflectionClass($route[1]);

                    if (!$reflect->isSubclassOf(AbstractController::class)) {
                        throw new InappropriateTypeException('Route controller must be instance of ' . AbstractController::class);
                    }

                    if (!$reflect->hasMethod($route[2])) {
                        throw new MethodNotFoundException('Route method was not found in ' . $route[1] . ' class');
                    }

                    $this->matchedRoute = $route;
                    break;
                }
            }
        }

        if ($this->matchedRoute === null) {
            throw new FileNotFoundException('Route was not found');
        }

        unset($matches[0]);

        return new DispatchedRoute($this->matchedRoute, $matches);
    }
}