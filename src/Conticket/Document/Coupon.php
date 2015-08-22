<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument */
final class Coupon
{
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $description;

    /** @ODM\String */
    private $code;

    /** @ODM\Float */
    private $value;

    /** @ODM\Int */
    private $quantity;

    /** @ODM\Date */
    private $expire;

    /**
     * Constructor
     *
     * @param string    $name
     * @param string    $description
     * @param string    $code
     * @param float     $value
     * @param int       $quantity
     * @param \DateTime $expire
     */
    public function __construct($name, $description, $code, $value, $quantity, \DateTime $expire)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->code        = $code;
        $this->value       = (float) $value;
        $this->quantity    = (int) $quantity;
        $this->expire      = $expire;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getExpire()
    {
        return $this->expire;
    }
}
