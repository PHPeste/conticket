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

declare(strict_types=1);

namespace Conticket\Model\Aggregates\Event;

use Conticket\Model\Events\Event\TicketPriceWasSet;
use Conticket\Model\Events\Event\TicketWasCreated;
use Prooph\EventSourcing\AggregateRoot;
use Conticket\Model\Events\Event\TicketLifespanWasSet;
use Conticket\Model\Events\Event\TicketQuantityWasSet;
use Rhumsaa\Uuid\Uuid;

final class Ticket extends AggregateRoot
{
    private $aggregateId;
    private $eventId;
    private $name;
    private $description;
    private $lifespan;
    private $quantity;
    private $price;
    private $status;

    public function aggregateId() : TicketId
    {
        return $this->aggregateId;
    }

    public static function fromEventIdAndNameAndDescription(EventId $eventId, string $name, string $description) : self
    {
        $ticket = new self();
        $ticket->recordThat(TicketWasCreated::fromTicketIdAndEventIdAndNameAndDescription(
            new TicketId(Uuid::uuid4()),
            $eventId,
            $name,
            $description
        ));
        return $ticket;
    }

    public function whenTicketWasCreated(TicketWasCreated $ticketWasCreated)
    {
        $this->aggregateId = $ticketWasCreated->aggregateId();
        $this->eventId = EventId::fromString($ticketWasCreated->eventId());
        $this->name = $ticketWasCreated->name();
        $this->description = $ticketWasCreated->description();
        $this->status = TicketStatus::INACTIVE;
    }

    public function setLifespan(\DateTimeImmutable $start, \DateTimeImmutable $end) : void
    {
        $this->recordThat(TicketLifeSpanWasSet::fromTicketAndStartDateAndEndDate(
            $this, $start, $end
        ));
    }

    public function whenTicketLifespanWasSet(TicketLifespanWasSet $ticketLifespanWasSet) : void
    {
        $this->lifespan = TicketLifespan::fromStartAndEnd(
            new \DateTimeImmutable($ticketLifespanWasSet->start()),
            new \DateTimeImmutable($ticketLifespanWasSet->end())
        );
    }

    public function setQuantity(TicketQuantity $ticketQuantity) : void
    {
        $this->recordThat(TicketQuantityWasSet::fromTicketAndTicketQuantity($this, $ticketQuantity));
    }

    public function whenTicketQuantityWasSet(TicketQuantityWasSet $ticketQuantityWasSet) : void
    {
        $this->quantity = TicketQuantity::fromInteger($ticketQuantityWasSet->value());
    }

    public function setPrice(TicketPrice $ticketPrice) : void
    {
        $this->recordThat(TicketPriceWasSet::fromTicketAndTicketPrice($this, $ticketPrice));
    }

    public function whenTicketPriceWasSet(TicketPriceWasSet $ticketPriceWasSet) : void
    {
        $this->price = TicketPrice::fromAmount($ticketPriceWasSet->value());
    }

}
