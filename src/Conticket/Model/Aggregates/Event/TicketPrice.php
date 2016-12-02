<?php

declare(strict_types=1);

namespace Conticket\Model\Aggregates\Event;

use Money\Currency;
use Money\Money;

final class TicketPrice
{

    const CURRENCY_DEFAULT = 'BRL';

    private $value;

    private function __construct(Money $value)
    {
        $this->value = $value;
    }

    public static function fromAmount(string $amount, string $code = self::CURRENCY_DEFAULT)
    {
        return new self(new Money($amount, new Currency($code)));
    }

    public function amount() : string
    {
        return (string) $this->value->getAmount();
    }
}