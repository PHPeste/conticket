<?php

namespace Feature;

use Behat\MinkExtension\Context\MinkContext;
use Doctrine\DBAL\Connection;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class AbstractContext extends MinkContext
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @return Connection
     */
    public function connection(): Connection
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection(Connection $connection): void
    {
        $this->connection = $connection;
    }
}
