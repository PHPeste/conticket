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

/** @ODM\Document */
final class User implements DocumentInterface
{
    /** @ODM\Id */
    private $id;

    /** @ODM\String */
    private $name;
    
    /** @ODM\String */
    private $token;
    
    /** @ODM\String */
    private $provider;

    /** @ODM\String */
    private $email;
    
    /** @ODM\ReferenceMany(targetDocument="Event", cascade="all") */
    private $events = [];
    
    /** @ODM\EmbedMany(targetDocument="Order") */
    private $orders = [];

    public function __construct($name, $email, $provider, $token)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->provider = $provider;
        $this->token    = $token;
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
