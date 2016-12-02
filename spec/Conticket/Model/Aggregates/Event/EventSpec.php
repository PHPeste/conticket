<?php

namespace spec\Conticket\Model\Aggregates\Event;

use Conticket\Model\Aggregates\Event\EventId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Conticket\Model\Aggregates\Event\Event;

class EventSpec extends ObjectBehavior
{

    public function let()
    {
        $this->beConstructedThrough('fromNameAndDescription', [
            'Event specification by example',
            'Description of event specified by example'
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Event::class);
    }

    public function it_should_return_event_id()
    {
        $this->aggregateId()->shouldReturnAnInstanceOf(EventId::class);
    }
}
