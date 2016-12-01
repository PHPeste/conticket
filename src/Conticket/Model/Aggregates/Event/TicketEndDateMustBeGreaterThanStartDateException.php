<?php

namespace Conticket\Model\Aggregates\Event;

class TicketEndDateMustBeGreaterThanStartDateException extends \Exception
{
    public function __construct($message = 'Ticket end date must be greater than start date')
    {
        parent::__construct($message);
    }
}