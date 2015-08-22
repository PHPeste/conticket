<?php

namespace Conticket\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\Document */
class Event
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
    
    public function getBanner()
    {
        return $this->banner;
    }
    
    public function setBanner($banner)
    {
        $this->banner = $banner;
    }
    
    public function setGateway(Gateway $gateway)
    {
        $this->gateway = $gateway;
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