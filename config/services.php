<?php

declare(strict_types=1);

use Conference\Domain\Repository\ConferenceRepositoryInterface;
use Conference\Factory\Repository\ConferenceRepositoryFactory;
use Conticket\Conference\Factory\CommandHandler\CreateConferenceHandlerFactory;
use Conticket\Conference\Domain\Command\CreateConference;
use Conticket\Conference\Infrastructure\Service\CommandBusFactory;
use Interop\Container\ContainerInterface;
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

            // @todo move commands/events to another config file
            CreateConference::class => CreateConferenceHandlerFactory::class,

            // @todo move repository to another file
            ConferenceRepositoryInterface::class => ConferenceRepositoryFactory::class,
        ]
    ];
})();
