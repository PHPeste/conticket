<?php

declare(strict_types=1);

use Conticket\Conference\Infrastructure\Middleware\CreateConferenceMiddleware;
use Conticket\Conference\Factory\Middleware\CreateConferenceMiddlewareFactory;

return [
    'factories' => [
        CreateConferenceMiddleware::class => CreateConferenceMiddlewareFactory::class,
    ],
];
