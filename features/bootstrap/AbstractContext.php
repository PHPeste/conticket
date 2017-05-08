<?php

namespace Feature;

use Behat\MinkExtension\Context\MinkContext;
use Doctrine\ORM\EntityManager;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class AbstractContext extends MinkContext
{
    /**
     * @var EntityManager
     */
    protected $manager;

    /**
     * @return EntityManager
     */
    public function getManager(): EntityManager
    {
        return $this->manager;
    }

    /**
     * @param EntityManager $manager
     */
    public function setManager(EntityManager $manager): void
    {
        $this->manager = $manager;
    }
}
