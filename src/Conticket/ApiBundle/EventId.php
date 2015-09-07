<?php

namespace Conticket\ApiBundle;

/**
 * @author  Jefersson Nathan <malukenho@phpse.net>
 */
final class EventId implements Identifier
{
    /**
     * @var string
     */
    private $eventId;

    /**
     * @param string $eventId
     */
    public function __construct($eventId)
    {
        $this->eventId = $eventId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->eventId;
    }
}
