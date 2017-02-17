<?php

declare(strict_types=1);

namespace Conticket\Conference\Domain\Repository;

use Conticket\Conference\Domain\Conference;
use Conticket\Conference\Domain\ConferenceId;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
interface ConferenceRepositoryInterface
{
    public function get(ConferenceId $conferenceId): Conference;

    public function store(Conference $conference): void;
}
