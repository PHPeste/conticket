<?php

declare(strict_types=1);

use Conticket\Conference\Infrastructure\Service\CommandBusFactory;
use Conticket\Conference\Infrastructure\Service\ConnectionFactory;
use Conticket\Conference\Infrastructure\Service\EventStoreFactory;
use Conticket\Conference\Infrastructure\Service\ApplicationFactory;
use Conticket\Conference\Infrastructure\Service\RouterFactory;
use Doctrine\DBAL\Connection;
use Prooph\EventStore\EventStore;
use Prooph\ServiceBus\CommandBus;
use Zend\Expressive\Application;
use Zend\Expressive\Router\FastRouteRouter;


return (function () {
    return [
        'factories' => [
            Application::class     => ApplicationFactory::class,
            FastRouteRouter::class => RouterFactory::class,
            CommandBus::class => CommandBusFactory::class,
            EventStore::class => EventStoreFactory::class,
            Connection::class => ConnectionFactory::class,

            // @todo move db info to a class to get ENV vars
            'db_dsn' => function () {
                return 'mysql:host=localhost;dbname=conticket';
            },
            'db_user' => function () {
                return 'root';
            },
            'db_password' => function () {
                return null;
            },
        ],
    ];
})();
