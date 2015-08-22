<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument */
class Order
{
    const WAITING = "waiting";
    const CANCELED = "canceled";
    const APPROVED = "approved";
    
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
    private $status = self::WAITING;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getValue()
    {
        return $this->value;
    }
    
    public function setValue($value)
    {
        $this->value = (float) $value;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    public function setTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
    
    public function setCoupon(Coupon $coupon)
    {
        $this->coupon = $coupon;
    }
}
