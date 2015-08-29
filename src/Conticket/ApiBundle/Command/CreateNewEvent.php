<?php

namespace Conticket\ApiBundle\Command;

use Conticket\ApiBundle\EventId;

/**
 * @author  Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateNewEvent
{
    /**
     * @var EventId
     */
    private $eventId;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;

    /**
     * @param EventId $eventId
     * @param string  $title
     * @param string  $description
     */
    public function __construct(EventId $eventId, $title, $description)
    {
        $this->eventId     = $eventId;
        $this->title       = $title;
        $this->description = $description;
    }
}
