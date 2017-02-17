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

namespace Conticket\Conference\Domain;

use Conticket\Conference\Domain\Event\ConferenceWasCreated;
use Prooph\EventSourcing\AggregateRoot;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class Conference extends AggregateRoot
{
    /**
     * @var ConferenceId
     */
    private $conferenceId;

    public static function new(
        ConferenceId $conferenceId,
        string $name,
        string $description,
        string $author,
        \DateTimeImmutable $date
    ): self {
        $self = new self();
        $self->recordThat(ConferenceWasCreated::fromRequestData($conferenceId, $name, $description, $author, $date));

        return $self;
    }

    public function whenConferenceWasCreated(ConferenceWasCreated $event): void
    {
        $this->conferenceId = ConferenceId::fromString($event->aggregateId());
    }

    /**
     * @todo move it to a trait
     *
     * @return array
     */
    public function popRecordedEvents(): array
    {
        return $this->recordedEvents;
    }

    /**
     * @return ConferenceId
     */
    public function conferenceId(): ConferenceId
    {
        return $this->conferenceId;
    }

    /**
     * {@inheritDoc}
     */
    protected function aggregateId(): string
    {
        return (string) $this->conferenceId;
    }
}
