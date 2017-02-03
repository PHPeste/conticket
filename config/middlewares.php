<?php

use Conticket\Conference\Infrastructure\Middleware\CreateAConference;
use Conticket\Conference\Factory\Middleware\CreateAConferenceFactory;

return [
    'factories' => [
        CreateAConference::class => CreateAConferenceFactory::class,
    ],
];
