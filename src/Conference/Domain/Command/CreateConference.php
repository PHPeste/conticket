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

namespace Conticket\Conference\Domain\Command;

use Assert\Assertion;
use Conticket\Conference\Domain\ConferenceId;
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

    private function __construct(
        ConferenceId $conferenceId,
        string $name,
        string $description,
        string $author,
        \DateTimeImmutable $date
    ) {
        Assertion::notEmpty($name);
        Assertion::notEmpty($description);
        Assertion::notEmpty($author);

        $this->conferenceId = $conferenceId;
        $this->name         = $name;
        $this->description  = $description;
        $this->author       = $author;
        $this->date         = $date;
    }

    public static function fromRequestData(
        ConferenceId $conferenceId,
        string $name,
        string $description,
        string $author,
        \DateTimeImmutable $date
    ): self {
        return new self($conferenceId, $name, $description, $author, $date);
    }

    /**
     * {@inheritDoc}
     */
    public function payload(): array
    {
        return [
            'name'         => $this->name,
            'description'  => $this->description,
            'author'       => $this->author,
            'conferenceId' => (string) $this->conferenceId,
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
