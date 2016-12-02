<?php

declare(strict_types=1);

namespace Conticket\Model\Aggregates\Event;

use Assert\Assertion;

final class TicketQuantity
{
    private $value;

    private function __construct(integer $value)
    {
        $this->value;
    }

    public static function fromInteger(integer $value)
    {
        Assertion::min(1, $value);

        return new self($value);
    }

    public function value() : int
    {
        return $this->value;
    }
}
