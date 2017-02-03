<?php

namespace Conticket\Conference\Command;

use Assert\Assertion;
use Conticket\Conference\ConferenceId;
use Prooph\Common\Messaging\Command;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateConference extends Command
{
    /**
     * @var ConferenceId
     */
    private $conferenceId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $author;

    /**
     * @var \DateTimeImmutable
     */
    private $date;

    private function __construct()
    {
    }

    public static function fromRequestData(
        ConferenceId $conferenceId,
        string $name,
        string $description,
        string $author,
        \DateTimeImmutable $date
    ): self {
        // @todo move to __constructor
        Assertion::notEmpty($name);
        Assertion::notEmpty($description);
        Assertion::notEmpty($author);

        $self               = new self();
        $self->conferenceId = (string) $conferenceId;
        $self->name         = $name;
        $self->description  = $description;
        $self->author       = $author;
        $self->date         = $date->format('U.u');

        return $self;
    }

    /**
     * {@inheritDoc}
     */
    public function payload(): array
    {
        return [
            'name'         => $this->name,
            'description'  => $this->description,
            'conferenceId' => (string) $this->conferenceId,
            'author'       => $this->author,
            'date'         => $this->date->format('U.u'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function setPayload(array $payload): void
    {
        [
            $this->name,
            $this->description,
            $this->author,
            $this->conferenceId,
            $this->date
        ] = [
            $payload['name'],
            $payload['description'],
            $payload['author'],
            ConferenceId::fromString($payload['description']),
            \DateTimeImmutable::createFromFormat('U.u', $payload['date']),
        ];
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return ConferenceId
     */
    public function getConferenceId(): ConferenceId
    {
        return $this->conferenceId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }
}
