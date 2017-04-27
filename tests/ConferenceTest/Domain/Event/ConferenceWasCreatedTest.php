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

namespace ConticketTest\ConferenceTest\Domain\Event;

use Conticket\Conference\Domain\ConferenceId;
use Conticket\Conference\Domain\Event\ConferenceWasCreated;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Conticket\Conference\Domain\Event\ConferenceWasCreated
 *
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceWasCreatedTest extends PHPUnit_Framework_TestCase
{
    public function test_it_can_create_event_from_conference_info()
    {
        $conferenceId          = ConferenceId::new();
        $conferenceName        = 'Conference Name';
        $conferenceDescription = 'Conference description';
        $conferenceAuthor      = 'Conference author';
        $conferenceDate        = new \DateTimeImmutable('now');

        $event = ConferenceWasCreated::fromRequestData(
            $conferenceId,
            $conferenceName,
            $conferenceDescription,
            $conferenceAuthor,
            $conferenceDate
        );

        self::assertEquals($conferenceId, $event->getConferenceId());
        self::assertSame($conferenceName, $event->getName());
        self::assertSame($conferenceDescription, $event->getDescription());
        self::assertSame($conferenceAuthor, $event->getAuthor());
        self::assertEquals($conferenceDate, $event->getDate());

        self::assertSame(
            [
                'name'         => $conferenceName,
                'description'  => $conferenceDescription,
                'conferenceId' => (string) $conferenceId,
                'author'       => $conferenceAuthor,
                'date'         => $conferenceDate->format('U.u'),
            ],
            $event->payload()
        );
    }
}
