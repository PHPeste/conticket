<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */
namespace Conticket\ApiBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 */
final class Event implements DocumentInterface
{
    /**
     * @ODM\Id
     */
    private $id;

    /**
     * @ODM\String
     */
    private $name;

    /**
     * @ODM\String
     */
    private $description;

    /**
     * @ODM\String
     */
    private $banner;

    /**
     * @ODM\EmbedOne(targetDocument="Gateway")
     */
    private $gateway;

    /**
     * @ODM\EmbedMany(targetDocument="Ticket")
     */
    private $tickets;

    /**
     * @ODM\EmbedMany(targetDocument="Coupon")
     */
    private $coupons;

    /**
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

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * @return Gateway|null
     */
    public function getGateway()
    {
        return $this->gateway;
    }

    /**
     * @return mixed
     */
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * @return mixed
     */
    public function getCoupons()
    {
        return $this->coupons;
    }

    /**
     * @param Ticket $ticket
     */
    public function addTicket(Ticket $ticket)
    {
        $this->tickets[] = $ticket;
    }

    /**
     * @param Coupon $coupon
     */
    public function addCoupon(Coupon $coupon)
    {
        $this->coupons[] = $coupon;
    }

    /**
     * @param string       $name
     * @param string       $description
     * @param string       $banner
     * @param Gateway|null $gateway
     * @return $this
     */
    public function populate($name, $description, $banner, Gateway $gateway = null)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->banner      = $banner;
        $this->gateway     = $gateway;
        $this->tickets     = [];
        $this->coupons     = [];

        return $this;
    }
}
