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

namespace Conticket\Model\Events\Event;

use Conticket\Model\Aggregates\Event\EventId;
use Conticket\Model\Aggregates\Event\Ticket;
use Prooph\EventSourcing\AggregateChanged;

final class TicketLifespanWasSet extends AggregateChanged
{
    public static function fromTicketAndStartDateAndEndDate(
        Ticket $ticket, \DateTimeImmutable $start, \DateTimeImmutable $end
    ) : self
    {
        return self::occur((string) $ticket->aggregateId(), [
            'start' => (string) $start->format('Y-m-d H:i:s'),
            'end' => (string) $end->format('Y-m-d H:i:s'),
        ]);
    }

    public function start() : string
    {
        return $this->payload['start'];
    }

    public function end() : string
    {
        return $this->payload['end'];
    }
}
