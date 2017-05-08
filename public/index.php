<?php

declare(strict_types=1);

use Conticket\Conference\Infrastructure\Middleware\CreateConferenceMiddleware;
use Conticket\Conference\Infrastructure\Middleware\ListConferencesMiddleware;
use Zend\Expressive\Application;

(function () {
    require __DIR__ . '/../vendor/autoload.php';

    (new \Dotenv\Dotenv(__DIR__ . '/..'))->load();

    /* @var $serviceManager \Zend\ServiceManager\ServiceManager */
    $serviceManager = require __DIR__ . '/../config/service-manager.php';

    /* @var $app Application */
    $app = $serviceManager->get(Application::class);

    $app->get(ListConferencesMiddleware::PATH, ListConferencesMiddleware::class);

    // @todo change it to POST
    $app->get(CreateConferenceMiddleware::PATH, CreateConferenceMiddleware::class);

    $app->pipeRoutingMiddleware();
    $app->pipeDispatchMiddleware();
    $app->raiseThrowables();
    $app->run();
})();
