<?php

declare(strict_types=1);

namespace Conticket\Conference\Factory\CommandHandler;

use Conticket\Conference\Domain\Repository\ConferenceRepositoryInterface;
use Conticket\Conference\Domain\CommandHandler\CreateConferenceHandler;
use Interop\Container\ContainerInterface;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateConferenceHandlerFactory
{
    public function __invoke(ContainerInterface $container): CreateConferenceHandler
    {
        return new CreateConferenceHandler(
            $container->get(ConferenceRepositoryInterface::class)
        );
    }
}
