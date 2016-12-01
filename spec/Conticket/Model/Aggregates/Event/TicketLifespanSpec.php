<?php

namespace spec\Conticket\Model\Aggregates\Event;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Conticket\Model\Aggregates\Event\TicketEndDateMustBeGreaterThanStartDateException;

class TicketLifespanSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Conticket\Model\Aggregates\Event\TicketLifespan');
    }

    function it_throws_an_exception_when_start_date_is_greater_than_end_date()
    {
        $this->beConstructedThrough('fromStartAndEnd', ['2016-01-01', '2015-01-01']);
        $this->shouldThrow(TicketEndDateMustBeGreaterThanStartDateException::class);
    }

    function it_should_return_datetimes_objects_on_start_and_end_methods()
    {
        $this->beConstructedThrough('fromStartAndEnd', ['2016-01-01', '2016-04-01']);
        $this->start()->shouldReturnAnInstanceOf(\DateTime::class);
        $this->end()->shouldReturnAnInstanceOf(\DateTime::class);
    }
}
