<?php

declare(strict_types=1);

namespace Conticket\Conference\Domain\CommandHandler;

use Conticket\Conference\Domain\Conference;
use Conticket\Conference\Domain\Repository\ConferenceRepositoryInterface;
use Conticket\Conference\Domain\Command\CreateConference;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateConferenceHandler
{
    /**
     * @var ConferenceRepositoryInterface
     */
    private $repository;

    public function __construct(ConferenceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(CreateConference $command)
    {
        $this->repository->store(Conference::new(
            $command->getConferenceId(),
            $command->getName(),
            $command->getDescription(),
            $command->getAuthor(),
            $command->getDate()
        ));
    }
}
