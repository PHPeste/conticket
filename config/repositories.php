<?php

declare(strict_types=1);

use Conticket\Conference\Domain\Repository\ConferenceRepositoryInterface;
use Conticket\Conference\Factory\Repository\ConferenceRepositoryFactory;

return (function () {
    return [
        'factories' => [
            ConferenceRepositoryInterface::class => ConferenceRepositoryFactory::class,
        ],
    ];
})();
