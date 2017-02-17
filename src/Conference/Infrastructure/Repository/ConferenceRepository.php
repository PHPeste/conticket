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

namespace Conticket\Conference\Infrastructure\Repository;

use Conticket\Conference\Domain\Repository\ConferenceRepositoryInterface;
use Conticket\Conference\Domain\Conference;
use Conticket\Conference\Domain\ConferenceId;
use Prooph\EventStore\Aggregate\AggregateRepository;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceRepository extends AggregateRepository implements ConferenceRepositoryInterface
{
    /**
     * {@inheritDoc}
     *
     * @throws \DomainException
     */
    public function get(ConferenceId $conferenceId): Conference
    {
        $conference = $this->getAggregateRoot((string) $conferenceId);

        if (! $conference instanceof Conference) {
            throw new \DomainException(sprintf('Could not load aggregate using id "%s"', $conferenceId));
        }

        return $conference;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     * @throws \Prooph\EventStore\Aggregate\Exception\AggregateTypeException
     */
    public function store(Conference $conference): void
    {
        $this
            ->eventStore
            ->transactional(function () use ($conference) {
                $this->addAggregateRoot($conference);
            });
    }
}
