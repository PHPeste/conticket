<?php

declare(strict_types=1);

use Conticket\Conference\Infrastructure\Middleware\CreateConferenceMiddleware;

(function () {
    require __DIR__ . '/../vendor/autoload.php';

    /* @var $serviceManager \Zend\ServiceManager\ServiceManager */
    $serviceManager = require __DIR__ . '/../config/service-manager.php';

    /* @var $app \Zend\Expressive\Application */
    $app = $serviceManager->get(\Zend\Expressive\Application::class);

    // @todo change it to POST
    $app->get(CreateConferenceMiddleware::PATH, CreateConferenceMiddleware::class);

    $app->pipeRoutingMiddleware();
    $app->pipeDispatchMiddleware();
    $app->raiseThrowables();
    $app->run();
})();
