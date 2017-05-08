<?php

declare(strict_types=1);

use Conticket\Conference\Factory\Middleware\ListConferencesMiddlewareFactory;
use Conticket\Conference\Infrastructure\Middleware\CreateConferenceMiddleware;
use Conticket\Conference\Factory\Middleware\CreateConferenceMiddlewareFactory;
use Conticket\Conference\Infrastructure\Middleware\ListConferencesMiddleware;

return (function () {
    return [
        'factories' => [
            CreateConferenceMiddleware::class => CreateConferenceMiddlewareFactory::class,
            ListConferencesMiddleware::class => ListConferencesMiddlewareFactory::class,
        ],
    ];
})();
