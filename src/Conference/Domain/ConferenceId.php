<?php

namespace Conticket\Conference\Domain;

use Rhumsaa\Uuid\Uuid;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceId
{
    /**
     * @var Uuid
     */
    private $uuid;

    private function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function new(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $uuid): self
    {
        return new self(Uuid::fromString($uuid));
    }

    public function __toString(): string
    {
        return (string) $this->uuid;
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }
}
