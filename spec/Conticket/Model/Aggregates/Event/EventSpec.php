<?php

namespace spec\Conticket\Model\Aggregates\Event;

use Conticket\Model\Aggregates\Event\EventId;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EventSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedThrough('fromNameAndDescription', [
            'Event specification by example',
            'Description of event specified by example'
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Conticket\Model\Aggregates\Event\Event');
    }

    function it_should_return_event_id()
    {
        $this->aggregateId()->shouldReturnAnInstanceOf(EventId::class);
    }
}
