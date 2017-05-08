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

namespace ConticketTest\ConferenceTest\Domain\Command;

use Conticket\Conference\Domain\Command\CreateConference;
use Conticket\Conference\Domain\ConferenceId;
use DateTimeImmutable;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Conticket\Conference\Domain\Command\CreateConference
 *
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateConferenceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ConferenceId
     */
    private $conferenceId;
    /**
     * @var string
     */
    private $conferenceName;
    /**
     * @var string
     */
    private $conferenceDescription;
    /**
     * @var string
     */
    private $conferenceAuthor;
    /**
     * @var DateTimeImmutable
     */
    private $conferenceDate;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $this->conferenceId          = ConferenceId::new();
        $this->conferenceName        = 'Conference name';
        $this->conferenceDescription = 'Conference description';
        $this->conferenceAuthor      = 'Conference author';
        $this->conferenceDate        = new DateTimeImmutable;
    }

    public function test_conference_name_should_not_be_empty(): void
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        CreateConference::fromRequestData(
            $this->conferenceId,
            '',
            $this->conferenceDescription,
            $this->conferenceAuthor,
            $this->conferenceDate
        );
    }

    public function test_conference_description_should_not_be_empty(): void
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        CreateConference::fromRequestData(
            $this->conferenceId,
            $this->conferenceName,
            '',
            $this->conferenceAuthor,
            $this->conferenceDate
        );
    }

    public function test_conference_author_should_not_be_empty(): void
    {
        $this->setExpectedException(\InvalidArgumentException::class);

        CreateConference::fromRequestData(
            $this->conferenceId,
            $this->conferenceName,
            $this->conferenceDescription,
            '',
            $this->conferenceDate
        );
    }

    public function test_create_conference(): void
    {
        $command = CreateConference::fromRequestData(
            $this->conferenceId,
            $this->conferenceName,
            $this->conferenceDescription,
            $this->conferenceAuthor,
            $this->conferenceDate
        );

        self::assertSame($this->conferenceId, $command->getConferenceId());
        self::assertSame($this->conferenceName, $command->getName());
        self::assertSame($this->conferenceDescription, $command->getDescription());
        self::assertSame($this->conferenceAuthor, $command->getAuthor());
        self::assertSame($this->conferenceDate, $command->getDate());

        self::assertSame(
            [
                'name'         => $this->conferenceName,
                'description'  => $this->conferenceDescription,
                'author'       => $this->conferenceAuthor,
                'conferenceId' => (string) $this->conferenceId,
                'date'         => $this->conferenceDate->format('U.u'),
            ],
            $command->payload()
        );

        /* @var $nakedCommand CreateConference */
        $nakedCommand = (new \ReflectionClass(CreateConference::class))->newInstanceWithoutConstructor();
        $nakedCommand->setPayload($command->payload());

        self::assertEquals($command, $nakedCommand);
    }
}
