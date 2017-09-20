<?php

namespace spec\Knp\Rad\DomainEvent;

use PhpSpec\ObjectBehavior;

class EventSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('SomeEventName', [
            'first_prop' => 3,
            'second_prop' => 'lorem',
        ]);
    }

    function it_tells_if_a_property_exists()
    {
        $this->has('first_prop')->shouldReturn(true);
        $this->has('second_prop')->shouldReturn(true);
        $this->has('third_prop')->shouldReturn(false);
    }

    function it_throws_an_exception_if_the_property_does_not_exist()
    {
        $this->__get('first_prop')->shouldReturn(3);
        $this->first_prop->shouldReturn(3);

        $this
            ->shouldThrow(new \RuntimeException(
                'Property third_prop does not exist on event SomeEventName'
            ))
            ->during('__get', ['third_prop'])
        ;
    }
}
