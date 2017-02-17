<?php

declare(strict_types=1);

namespace Conticket\Conference\Infrastructure\Service;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use Interop\Container\ContainerInterface;
use PDO;

final class ConnectionFactory
{
    public function __invoke(ContainerInterface $container): Connection
    {
        // @todo create service for \PDO
        return new Connection(
            [
                'pdo' => new PDO(
                    $container->get('db_dsn'),
                    $container->get('db_user'),
                    $container->get('db_password')
                ),
            ],
            new Driver()
        );
    }
}
