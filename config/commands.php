<?php

declare(strict_types=1);

use Conticket\Conference\Factory\CommandHandler\CreateConferenceHandlerFactory;
use Conticket\Conference\Domain\Command\CreateConference;

return (function () {
    return [
        'factories' => [
            CreateConference::class => CreateConferenceHandlerFactory::class,
        ],
    ];
})();
