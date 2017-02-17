<?php

declare(strict_types=1);

namespace Conticket\Conference\Infrastructure\Service;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Doctrine\DBAL\Schema\SchemaException;
use Interop\Container\ContainerInterface;
use PDO;
use Prooph\EventStore\Adapter\Doctrine\Schema\EventStoreSchema;

final class ConnectionFactory
{
    public function __invoke(ContainerInterface $container): Connection
    {
        // @todo create service for \PDO
        $connection = new Connection(
            [
                'pdo' => new PDO(
                    $container->get('db_dsn'),
                    $container->get('db_user'),
                    $container->get('db_password')
                ),
            ],
            new Driver()
        );

        try {
            $schema = $connection->getSchemaManager()->createSchema();

            EventStoreSchema::createSingleStream($schema);

            foreach ($schema->toSql($connection->getDatabasePlatform()) as $sql) {
                $connection->exec($sql);
            }
        } catch (SchemaException $ignored) {
            // this is ignored for now - we don't want to re-create the schema every time
        }

        return $connection;
    }
}
