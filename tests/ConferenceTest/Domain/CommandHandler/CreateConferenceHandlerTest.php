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

namespace ConticketTest\ConferenceTest\Domain\CommandHandler;

use Conticket\Conference\Domain\Command\CreateConference;
use Conticket\Conference\Domain\CommandHandler\CreateConferenceHandler;
use Conticket\Conference\Domain\ConferenceId;
use Conticket\Conference\Domain\Repository\ConferenceRepositoryInterface;
use PHPUnit_Framework_TestCase;

/**
 * @covers \Conticket\Conference\Domain\CommandHandler\CreateConferenceHandler
 *
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateConferenceHandlerTest extends PHPUnit_Framework_TestCase
{
    public function test_it_should_store_a_new_conference(): void
    {
        $command = CreateConference::fromRequestData(
            $conferenceId = ConferenceId::new(),
            $conferenceName = 'Conference name',
            $conferenceDescription = 'description',
            $conferenceAuthor ='author',
            new \DateTimeImmutable()
        );

        /* @var $repository \PHPUnit_Framework_MockObject_MockObject|ConferenceRepositoryInterface*/
        $repository = $this->createMock(ConferenceRepositoryInterface::class);

        $repository->expects(self::once())->method('store');

        $handler = new CreateConferenceHandler($repository);
        $handler->__invoke($command);
    }
}
