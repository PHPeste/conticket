<?php

declare(strict_types=1);

namespace Conference\Factory\Repository;

use Conference\Infrastructure\Repository\ConferenceRepository;
use Conticket\Conference\Conference;
use Interop\Container\ContainerInterface;
use Iterator;
use Prooph\EventStore\Aggregate\AggregateRepository;
use Prooph\EventStore\Aggregate\AggregateTranslator;
use Prooph\EventStore\Aggregate\AggregateType;
use Prooph\EventStore\Aggregate\Exception\AggregateTranslationFailedException;
use Prooph\EventStore\EventStore;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceRepositoryFactory
{
    public function __invoke(ContainerInterface $container): ConferenceRepository
    {
        return new ConferenceRepository(new AggregateRepository(
            // @todo create event store
            $container->get(EventStore::class),
            AggregateType::fromAggregateRootClass(Conference::class),
            $this->buildTranslator()
        ));
    }

    private function buildTranslator(): AggregateTranslator
    {
        return new class implements AggregateTranslator
        {
            /**
             * {@inheritDoc}
             *
             * @throws \Prooph\EventStore\Aggregate\Exception\AggregateTranslationFailedException
             */
            public function extractAggregateVersion($eventSourcedAggregateRoot)
            {
                throw new AggregateTranslationFailedException();
            }

            /**
             * {@inheritDoc}
             */
            public function extractAggregateId($eventSourcedAggregateRoot)
            {
                return (string) $eventSourcedAggregateRoot->getId();
            }

            /**
             * {@inheritDoc}
             */
            public function reconstituteAggregateFromHistory(AggregateType $aggregateType, Iterator $historyEvents)
            {
                return Conference::fromEvents(iterator_to_array($historyEvents));
            }

            /**
             * {@inheritDoc}
             */
            public function extractPendingStreamEvents($eventSourcedAggregateRoot)
            {
                return $eventSourcedAggregateRoot->popRecordedEvents();
            }

            /**
             * {@inheritDoc}
             *
             * @throws \Prooph\EventStore\Aggregate\Exception\AggregateTranslationFailedException
             */
            public function replayStreamEvents($anEventSourcedAggregateRoot, Iterator $events)
            {
                throw new AggregateTranslationFailedException();
            }
        };
    }
}
