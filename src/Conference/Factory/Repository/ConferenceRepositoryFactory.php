<?php

declare(strict_types=1);

namespace Conticket\Conference\Factory\Repository;

use Conticket\Conference\Infrastructure\Repository\ConferenceRepository;
use Conticket\Conference\Domain\Conference;
use Interop\Container\ContainerInterface;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\Aggregate\AggregateType;
use Prooph\EventStore\EventStore;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceRepositoryFactory
{
    public function __invoke(ContainerInterface $container): ConferenceRepository
    {
        return new ConferenceRepository(
            $container->get(EventStore::class),
            AggregateType::fromAggregateRootClass(Conference::class),
            new AggregateTranslator()
        );
    }
}
