<?php

namespace spec\Conticket\Model\Aggregates\Event;

use Conticket\Model\Aggregates\Event\TicketLifespan;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Conticket\Model\Aggregates\Event\TicketEndDateMustBeGreaterThanStartDateException;


final class TicketLifespanSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(TicketLifespan::class);
    }

    public function it_throws_an_exception_when_start_date_is_greater_than_end_date()
    {
        $this->shouldThrow(TicketEndDateMustBeGreaterThanStartDateException::class);
        $this->beConstructedThrough('fromStartAndEnd', [
            new \DateTimeImmutable('2016-01-01'),
            new \DateTimeImmutable('2015-01-01'),
        ]);
    }

    public function it_should_return_datetimes_objects_on_start_and_end_methods()
    {
        $this->beConstructedThrough('fromStartAndEnd', [
            new \DateTimeImmutable('2016-01-01'),
            new \DateTimeImmutable('2016-04-01'),
        ]);
        $this->start()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
        $this->end()->shouldReturnAnInstanceOf(\DateTimeImmutable::class);
    }
}
