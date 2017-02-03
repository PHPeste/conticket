<?php

declare(strict_types=1);

namespace Conticket\Conference\Infrastructure\Middleware;

use Conticket\Conference\Domain\ConferenceId;
use Conticket\Conference\Domain\Command\CreateConference;
use Prooph\ServiceBus\CommandBus;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Stratigility\MiddlewareInterface;

/**
 * @author Jefersson Nathan <malukenho@phpse.net>
 */
final class CreateConferenceMiddleware implements MiddlewareInterface
{
    const PATH = '/conference';

    /**
     * @var callable
     */
    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * {@inheritDoc}
     *
     * @throws \InvalidArgumentException
     * @throws \Prooph\ServiceBus\Exception\CommandDispatchException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        // @todo work with post parameters
        $commandBus = $this->commandBus;

        $command = CreateConference::fromRequestData(
            ConferenceId::new(),
            'blah',
            'desc',
            'author',
            new \DateTimeImmutable('now')
        );

        $commandBus->dispatch($command);

        // @todo return a json response

        $response->getBody()->write('aaa');

        return $response;
    }
}
