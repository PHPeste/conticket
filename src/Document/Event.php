<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
final class Event
{
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;

    /** @ODM\String */
    private $description;

    /** @ODM\String */
    private $banner;

    /** @ODM\EmbedOne(targetDocument="Gateway") */
    private $gateway;

    /** @ODM\EmbedMany(targetDocument="Ticket") */
    private $tickets;

    /** @ODM\EmbedMany(targetDocument="Coupon") */
    private $coupons;

    /**
     * Constructor
     *
     * @param string       $name
     * @param string       $description
     * @param string       $banner
     * @param Gateway|null $gateway
     */
    public function __construct($name, $description, $banner, Gateway $gateway = null)
    {

        $this->name        = $name;
        $this->description = $description;
        $this->banner      = $banner;
        $this->gateway     = $gateway;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getBanner()
    {
        return $this->banner;
    }

    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    public function addCoupon(Coupon $coupon)
    {
        $this->coupons[] = $coupon;
    }
}
