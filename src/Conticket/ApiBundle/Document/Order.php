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

/** @ODM\EmbeddedDocument */
final class Order implements DocumentInterface
{
    const WAITING  = 'waiting';
    const CANCELED = 'canceled';
    const APPROVED = 'approved';

    /** @ODM\Id */
    private $id;

    /** @ODM\ReferenceOne(targetDocument="Ticket", cascade="all") */
    private $ticket;

    /** @ODM\ReferenceOne(targetDocument="Coupon", cascade="all") */
    private $coupon;
    
    /** @ODM\ReferenceOne(targetDocument="Event", cascade="all") */
    private $event;

    /** @ODM\String */
    private $status;

    /**
     * @param string $name
     * @param float  $value
     * @param Ticket $ticket
     * @param Coupon $coupon
     * @param string $status
     */
    public function __construct(Event $event, User $user, Ticket $ticket, Coupon $coupon = null, $status = self::WAITING)
    {
        $this->event  = $event;
        $this->user   = $user;
        $this->ticket = $ticket;
        $this->coupon = $coupon;
        $this->status = $status;
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
