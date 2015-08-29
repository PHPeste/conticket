<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Routing\ClassResourceInterface;

final class EventController implements ClassResourceInterface
{
    /**
     * @var EventRepository
     */
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getEventAction()
    {
        
    }
}
