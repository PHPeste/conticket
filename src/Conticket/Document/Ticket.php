<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument */
final class Ticket
{
    const ACTIVE = "active";
    const INACTIVE = "inactive";
    
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $description;
    
    /** @ODM\Int */
    private $quantity;
    
    /** @ODM\Float */
    private $value;
    
    /** @ODM\Date */
    private $start;
    
    /** @ODM\Date */
    private $end;
    
    /** @ODM\String */
    private $status = self::ACTIVE;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getStart()
    {
        return $this->start;
    }
    
    public function setStart(\DateTime $date)
    {
        $this->start = $date;
    }
    
    public function getEnd()
    {
        return $this->end;
    }
    
    public function setEnd(\DateTime $date)
    {
        $this->end = $date;
    }
    
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
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
}
