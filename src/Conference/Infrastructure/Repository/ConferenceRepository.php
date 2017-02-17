<?php

declare(strict_types=1);

namespace Conticket\Conference\Infrastructure\Repository;

use Conticket\Conference\Domain\Repository\ConferenceRepositoryInterface;
use Conticket\Conference\Domain\Conference;
use Conticket\Conference\Domain\ConferenceId;
use Prooph\EventStore\Aggregate\AggregateRepository;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class ConferenceRepository implements ConferenceRepositoryInterface
{
    /**
     * @var AggregateRepository
     */
    private $repository;

    public function __construct(AggregateRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \DomainException
     */
    public function get(ConferenceId $conferenceId): Conference
    {
        $conference = $this->repository->getAggregateRoot((string) $conferenceId);

        if (! $conference instanceof Conference) {
            throw new \DomainException(sprintf('Could not load aggregate using id "%s"', $conferenceId));
        }

        return $conference;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Prooph\EventStore\Aggregate\Exception\AggregateTypeException
     */
    public function store(Conference $conference): void
    {
        $this->repository->addAggregateRoot($conference);
    }
}
