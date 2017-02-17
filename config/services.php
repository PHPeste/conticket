<?php

declare(strict_types=1);

use Conticket\Conference\Domain\Repository\ConferenceRepositoryInterface;
use Conticket\Conference\Factory\Repository\ConferenceRepositoryFactory;
use Conticket\Conference\Factory\CommandHandler\CreateConferenceHandlerFactory;
use Conticket\Conference\Domain\Command\CreateConference;
use Conticket\Conference\Infrastructure\Service\CommandBusFactory;
use Conticket\Conference\Infrastructure\Service\ConnectionFactory;
use Conticket\Conference\Infrastructure\Service\EventStoreFactory;
use Doctrine\DBAL\Connection;
use Interop\Container\ContainerInterface;
use Prooph\EventStore\EventStore;
use Prooph\ServiceBus\CommandBus;
use Zend\Expressive\Application;
use Zend\Expressive\Router\FastRouteRouter;

return (function () {
    return [
        // @todo move factories to proper classes
        'factories' => [
            Application::class     => function (ContainerInterface $container) {
                return new Application($container->get(FastRouteRouter::class), $container);
            },
            FastRouteRouter::class => function (ContainerInterface $container) {
                return new FastRouteRouter();
            },

            CommandBus::class => CommandBusFactory::class,
            EventStore::class => EventStoreFactory::class,
            Connection::class => ConnectionFactory::class,

            // @todo move commands/events to another config file
            CreateConference::class => CreateConferenceHandlerFactory::class,

            // @todo move repository to another file
            ConferenceRepositoryInterface::class => ConferenceRepositoryFactory::class,

            // @todo move db info to a class to get ENV vars
            'db_dsn' => function () {
                return 'mysql:host=localhost;dbname=conticket';
            },
            'db_user' => function () {
                return 'root';
            },
            'db_password' => function () {
                return 'root';
            },
        ],
    ];
})();
