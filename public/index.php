<?php

declare(strict_types=1);

use Conticket\Conference\Infrastructure\Middleware\CreateAConference;

(function () {
    require __DIR__ . '/../vendor/autoload.php';

    /* @var $serviceManager \Zend\ServiceManager\ServiceManager */
    $serviceManager = require __DIR__ . '/../config/service-manager.php';

    /* @var $app \Zend\Expressive\Application */
    $app = $serviceManager->get(\Zend\Expressive\Application::class);

    // @todo change it to POST
    $app->get(CreateAConference::PATH, CreateAConference::class);

    $app->pipeRoutingMiddleware();
    $app->pipeDispatchMiddleware();
    $app->run();
})();
