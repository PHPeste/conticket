<?php

namespace Conticket\Model\Aggregates\Event;

use Assert\Assertion;

class TicketLifespan
{
    private $start;
    private $end;

    protected function __construct(\DateTime $start, \DateTime $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public static function fromStartAndEnd($start, $end)
    {
        Assertion::notEmpty($start, "Start date is required.");
        Assertion::notEmpty($end, "End date is required.");

        $start = new \DateTime($start);
        $end = new \DateTime($end);

        if ($start > $end) {
            throw new TicketEndDateMustBeGreaterThanStartDateException();
        }

        return new self($start, $end);
    }

    public function start()
    {
        return $this->start;
    }

    public function end()
    {
        return $this->end;
    }

    public function expiresOn(){}

    public function daysLeft(){}

    public function expired(){}

}