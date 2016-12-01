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
namespace Conticket\Model\Aggregates\Event;

use Conticket\Model\Aggregates\Ticket\TicketId;
use Prooph\EventSourcing\AggregateRoot;

class Ticket extends AggregateRoot
{
    private $aggregateId;
    private $eventId;
    private $name;
    private $description;
    private $lifespan;
    private $quantity;
    private $value;
    private $status;

    public function aggregateId()
    {
        return $this->aggregateId;
    }

    public function fromIdAndNameAndDescription(TicketId $id, $name, $description)
    {
        $ticket = new self();
        $ticket->aggregateId = $id;
        $ticket->name = $name;
        $this->description = $description;
        $this->status = TicketStatus::INACTIVE;
    }
}
