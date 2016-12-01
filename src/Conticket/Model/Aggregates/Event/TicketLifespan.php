<?php

declare(strict_types=1);

namespace Conticket\Model\Aggregates\Event;

final class TicketLifespan
{
    private $start;
    private $end;

    protected function __construct(\DateTimeImmutable $start, \DateTimeImmutable $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public static function fromStartAndEnd(\DateTimeImmutable $start, \DateTimeImmutable $end): self
    {
        if ($start > $end) {
            throw new TicketEndDateMustBeGreaterThanStartDateException();
        }

        return new self($start, $end);
    }

    public function start() : \DateTimeImmutable
    {
        return $this->start;
    }

    public function end() : \DateTimeImmutable
    {
        return $this->end;
    }

    public function expiresOn(){}
    public function daysLeft(){}
    public function expired(){}
}
