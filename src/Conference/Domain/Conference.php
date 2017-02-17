<?php

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

    public function whenConferenceWasCreated(ConferenceWasCreated $event)
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
    public function conferenceId() : ConferenceId
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
