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

namespace ConticketTest\ConferenceTest\Domain;

use Conticket\Conference\Domain\Conference;
use Conticket\Conference\Domain\ConferenceId;
use Conticket\Conference\Domain\Event\ConferenceWasCreated;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Conticket\Conference\Domain\Conference
 *
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceTest extends PHPUnit_Framework_TestCase
{
    public function test_it_should_create_new_conference(): void
    {
        $conferenceId          = ConferenceId::new();
        $conferenceName        = 'Conference Name';
        $conferenceDescription = 'Conference description';
        $conferenceAuthor      = 'Conference author';
        $conferenceDate        = new \DateTimeImmutable('now');

        $conference = Conference::new(
            $conferenceId,
            $conferenceName,
            $conferenceDescription,
            $conferenceAuthor,
            $conferenceDate
        );

        self::assertInstanceOf(Conference::class, $conference);

        $event = $conference->popRecordedEvents();

        self::assertCount(1, $event);

        self::assertInstanceOf(ConferenceId::class, $event[0]->getConferenceId());
        self::assertEquals($conferenceId, $event[0]->getConferenceId());
        self::assertSame($conferenceName, $event[0]->getName());
        self::assertSame($conferenceDescription, $event[0]->getDescription());
        self::assertSame($conferenceAuthor, $event[0]->getAuthor());
        self::assertEquals($conferenceDate, $event[0]->getDate());
    }

    public function test_it_should_be_able_to_return_conference_id()
    {
        $conferenceId          = ConferenceId::new();
        $conferenceName        = 'Conference Name';
        $conferenceDescription = 'Conference description';
        $conferenceAuthor      = 'Conference author';
        $conferenceDate        = new \DateTimeImmutable('now');

        $conference = Conference::new(
            $conferenceId,
            $conferenceName,
            $conferenceDescription,
            $conferenceAuthor,
            $conferenceDate
        );

        self::assertEquals($conferenceId, $conference->conferenceId());
        self::assertSame((string) $conferenceId, (string) $conference->conferenceId());
    }
}
