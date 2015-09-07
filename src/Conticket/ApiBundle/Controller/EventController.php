<?php

namespace Conticket\ApiBundle\Controller;

use Broadway\CommandHandling\CommandBusInterface;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use Conticket\ApiBundle\Command\CreateNewEvent;
use Conticket\ApiBundle\EventId;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author  Jefersson Nathan <malukenho@phpse.net>
 */
final class EventController extends Controller
{
    /**
     * @var CommandBusInterface
     */
    private $commandBus;
    /**
     * @var UuidGeneratorInterface
     */
    private $uuidGenerator;

    /**
     * @param CommandBusInterface    $commandBus
     * @param UuidGeneratorInterface $uuidGenerator
     */
    public function __construct(CommandBusInterface $commandBus, UuidGeneratorInterface $uuidGenerator)
    {
        $this->commandBus    = $commandBus;
        $this->uuidGenerator = $uuidGenerator;
    }

    public function indexAction()
    {
        return $this->render('ApiBundle:Default:index.html.twig');
    }

    public function createAction(Request $request)
    {
        $title       = $request->request->get('title');
        $description = $request->request->get('description');

        $eventId = new EventId($this->uuidGenerator->generate());
        $command = new CreateNewEvent($eventId, $title, $description);

        $this->commandBus->dispatch($command);

        return new JsonResponse(['id' => (string) $eventId]);
    }
}
