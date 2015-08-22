<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument */
final class Order
{
    const WAITING  = 'waiting';
    const CANCELED = 'canceled';
    const APPROVED = 'approved';

    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;

    /** @ODM\Float */
    private $value;

    /** @ODM\ReferenceOne(targetDocument="Ticket", cascade="all") */
    private $ticket;

    /** @ODM\ReferenceOne(targetDocument="Coupon", cascade="all") */
    private $coupon;

    /** @ODM\String */
    private $status;

    /**
     * @param string $name
     * @param float  $value
     * @param Ticket $ticket
     * @param Coupon $coupon
     * @param string $status
     */
    public function __construct($name, $value, Ticket $ticket, Coupon $coupon, $status = self::WAITING)
    {
        $this->name   = $name;
        $this->value  = (float) $value;
        $this->ticket = $ticket;
        $this->coupon = $coupon;
        $this->status = $status;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getTicket()
    {
        return $this->ticket;
    }

    public function getCoupon()
    {
        return $this->coupon;
    }
}
