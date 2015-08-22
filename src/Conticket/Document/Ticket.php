<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument */
final class Ticket
{
    const ACTIVE   = 'active';
    const INACTIVE = 'inactive';

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
    private $status;

    /**
     * Constructor
     *
     * @param string    $name
     * @param string    $description
     * @param int       $quantity
     * @param float     $value
     * @param \DateTime $start
     * @param \DateTime $end
     * @param string    $status
     */
    public function __construct($name, $description, $quantity, $value, \DateTime $start, \DateTime $end, $status = self::ACTIVE)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->quantity    = (int) $quantity;
        $this->value       = (float) $value;
        $this->start       = $start;
        $this->end         = $end;
        $this->status      = $status;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
