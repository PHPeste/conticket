<?php

namespace Feature;

use Behat\Behat\Context\Initializer\ContextInitializer;
use Behat\Behat\Context\Context;
use Doctrine\DBAL\DriverManager;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class CustomInitializer extends AbstractContext implements ContextInitializer
{
    /**
     * @param Context $context
     *
     * @return bool
     */
    public function supportsContext(Context $context)
    {
        return $context instanceof AbstractContext;
    }

    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException
     * @throws \Doctrine\DBAL\DBALException
     */
    public function initializeContext(Context $context)
    {
        if (! $this->supportsContext($context)) {
            return;
        }

        $connection = DriverManager::getConnection(
            [
                // @todo move config to a better place
                'pdo' => new \PDO('mysql:host=localhost;dbname=conticket', 'root',  'root'),
            ]
        );

        /* @var AbstractContext $context */
        $context->setConnection($connection);
    }
}
