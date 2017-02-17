<?php

namespace Conticket\Conference\Domain\Event;

use Assert\Assertion;
use Conticket\Conference\Domain\ConferenceId;
use Prooph\EventSourcing\AggregateChanged;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceWasCreated extends AggregateChanged
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

    public static function fromRequestData(
        ConferenceId $conferenceId,
        string $name,
        string $description,
        string $author,
        \DateTimeImmutable $date
    ): self {
        Assertion::notEmpty($name);
        Assertion::notEmpty($description);
        Assertion::notEmpty($author);

        return self::occur(
            (string) $conferenceId,
            [
                'conferenceId' => (string) $conferenceId,
                'name'         => $name,
                'description'  => $description,
                'author'       => $author,
                'date'         => $date->format('U.u'),
            ]
        );
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
            ConferenceId::fromString($payload['conferenceId']),
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
