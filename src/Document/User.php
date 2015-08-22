<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
final class User
{
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $email;
    
    /** @ODM\ReferenceMany(targetDocument="Event", cascade="all") */
    private $events = [];
    
    /** @ODM\EmbedMany(targetDocument="Order") */
    private $orders = [];

    public function __construct($name, $email)
    {
        $this->name  = $name;
        $this->email = $email;
    }

    public function addEvent(Event $event)
    {
        $this->events[] = $event;
    }
    
    public function addOrder(Order $order)
    {
        $this->orders[] = $order;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
}
