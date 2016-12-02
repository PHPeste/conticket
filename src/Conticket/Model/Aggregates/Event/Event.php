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

use Prooph\EventSourcing\AggregateRoot;
use Conticket\Model\Events\Event\EventWasCreated;
use Conticket\Model\Events\Event\TicketWasAdded;
use Assert\Assertion;
use Rhumsaa\Uuid\Uuid;

final class Event extends AggregateRoot
{
    private $aggregateId;
    private $name;
    private $description;
    private $banner;
    private $gateway;

    public function aggregateId() : EventId
    {
        return $this->aggregateId;
    }

    public static function fromNameAndDescription($name, $description) : self
    {
        Assertion::notEmpty($name, 'Name is required.');
        Assertion::notEmpty($description, 'Description is required.');

        $event = new self();
        $event->recordThat(
            EventWasCreated::fromEventIdAndNameAndDescription(
                new EventId(Uuid::uuid4()),
                $name,
                $description
            )
        );
        return $event;
    }

    public function whenEventWasCreated(EventWasCreated $eventWasCreated) : void
    {
        $this->aggregateId = EventId::fromString($eventWasCreated->aggregateId());
        $this->name = $eventWasCreated->name();
        $this->description = $eventWasCreated->description();
    }

    public function addTicket(Ticket $ticket) : void
    {
        $this->recordThat(TicketWasAdded::fromEventAndTicket($this, $ticket));
    }
}
