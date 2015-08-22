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
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function addEvent($event)
    {
        $this->events[] = $event;
    }
    
    public function addOrder($order)
    {
        $this->orders[] = $order;
    }
}
