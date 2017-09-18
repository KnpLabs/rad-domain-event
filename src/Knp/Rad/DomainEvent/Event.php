<?php

namespace Knp\Rad\DomainEvent;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

class Event extends BaseEvent
{
    private $eventName;
    private $properties;
    private $subject;

    public function __construct($eventName, array $properties = array())
    {
        $this->eventName = $eventName;
        $this->properties = $properties;
    }

    public function getName()
    {
        return $this->eventName;
    }

    public function __get($name)
    {
        if (!$this->has($name)) {
            throw new \RuntimeException(sprintf(
                'Property %s does not exist on event %s',
                $name,
                $this->eventName
            ));
        }

        return $this->properties[$name];
    }

    public function has($name)
    {
        return array_key_exists($name, $this->properties);
    }

    public function setSubject(Provider $subject)
    {
        $this->subject = $subject;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}
