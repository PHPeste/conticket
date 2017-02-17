<?php

declare(strict_types=1);

namespace Conticket\Conference\Infrastructure\Service;

use Doctrine\DBAL\Connection;
use Interop\Container\ContainerInterface;
use Prooph\Common\Event\ProophActionEventEmitter;
use Prooph\Common\Messaging\FQCNMessageFactory;
use Prooph\Common\Messaging\NoOpMessageConverter;
use Prooph\EventStore\Adapter\Doctrine\DoctrineEventStoreAdapter;
use Prooph\EventStore\Adapter\PayloadSerializer\JsonPayloadSerializer;
use Prooph\EventStore\EventStore;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class EventStoreFactory
{
    public function __invoke(ContainerInterface $container): EventStore
    {
        $eventStore = new EventStore(
            new DoctrineEventStoreAdapter(
                $container->get(Connection::class),
                new FQCNMessageFactory(),
                new NoOpMessageConverter(),
                new JsonPayloadSerializer()
            ),
            new ProophActionEventEmitter()
        );

        return $eventStore;
    }
}
