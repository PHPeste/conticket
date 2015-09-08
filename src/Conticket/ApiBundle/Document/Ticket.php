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
final class Ticket implements DocumentInterface
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
