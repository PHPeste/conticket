<?php

declare(strict_types=1);

namespace Conticket\Conference\Factory\Middleware;

use Conticket\Conference\Infrastructure\Middleware\CreateConferenceMiddleware;
use Interop\Container\ContainerInterface;
use Prooph\ServiceBus\CommandBus;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateConferenceMiddlewareFactory
{
    /**
     * {@inheritDoc}
     *
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function __invoke(ContainerInterface $container): CreateConferenceMiddleware
    {
        return new CreateConferenceMiddleware(
            $container->get(CommandBus::class)
        );
    }
}
