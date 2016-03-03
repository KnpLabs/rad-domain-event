<?php

namespace spec\Knp\Rad\DomainEvent\Dispatcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Knp\Rad\DomainEvent\Provider;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Knp\Rad\DomainEvent\Event;

class DoctrineSpec extends ObjectBehavior
{
    function let(EventDispatcherInterface $dispatcher) {
        $this->beConstructedWith($dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Knp\Rad\DomainEvent\Dispatcher\Doctrine');
    }

    function it_pop_events_of_a_post_persisted_entity(
        LifecycleEventArgs $event,
        Provider $entity,
        PostFlushEventArgs $postFlushEvent,
        Event $raisedEvent,
        $dispatcher
    ) {
        $event->getEntity()->willReturn($entity);
        $entity->popEvents()->willReturn([$raisedEvent]);

        $raisedEvent->setSubject($entity)->shouldBeCalled();
        $raisedEvent->getName()->willReturn('FooEvent');
        $dispatcher->dispatch('FooEvent', $raisedEvent)->shouldBeCalled();

        $this->postPersist($event);
        $this->postFlush($postFlushEvent);
    }

    function it_pop_events_of_a_post_loaded_entity(
        LifecycleEventArgs $event,
        Provider $entity,
        PostFlushEventArgs $postFlushEvent,
        Event $raisedEvent,
        $dispatcher
    ) {
        $event->getEntity()->willReturn($entity);
        $entity->popEvents()->willReturn([$raisedEvent]);

        $raisedEvent->setSubject($entity)->shouldBeCalled();
        $raisedEvent->getName()->willReturn('FooEvent');
        $dispatcher->dispatch('FooEvent', $raisedEvent)->shouldBeCalled();

        $this->postLoad($event);
        $this->postFlush($postFlushEvent);
    }

    function it_doesnt_dispatch_events_of_non_provider_entities(
        LifecycleEventArgs $event,
        \StdClass $entity,
        PostFlushEventArgs $postFlushEvent,
        Event $raisedEvent,
        $dispatcher
    ) {
        $event->getEntity()->willReturn($entity);
        $dispatcher->dispatch(Argument::any(), $raisedEvent)->shouldNotBeCalled();

        $this->postPersist($event);
        $this->postFlush($postFlushEvent);
    }
}
