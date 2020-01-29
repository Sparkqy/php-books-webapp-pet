<?php

use Src\App;
use Src\Core\DI\DI;
use Src\Core\ServiceProviders\AbstractServiceProvider;
use Src\Exceptions\DIContainerException;

session_start();

try {
    $di = new DI();
    $serviceProviders = require ROOT . '/../src/Configs/service_providers.php';

    foreach ($serviceProviders as $serviceProvider) {
        /** @var AbstractServiceProvider $service */
        $service = new $serviceProvider($di);
        $service->init();
    }

    $app = new App($di);
    $app->run();
} catch (DIContainerException $e) {
    http_response_code(404);
    echo $e->getMessage();
    exit();
}