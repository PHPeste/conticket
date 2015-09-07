<?php

namespace Conticket\ApiBundle;

use Broadway\CommandHandling\CommandHandlerInterface;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
class EventCommandHandler implements CommandHandlerInterface
{
    /**
     * @param mixed $command
     */
    public function handle($command)
    {
        // TODO: pass repository to this command handler
        echo "command handled";
    }
}
