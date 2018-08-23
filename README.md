# Knp Rad Domain Event
[![Build Status](https://travis-ci.org/KnpLabs/rad-domain-event.svg?branch=master)](https://travis-ci.org/KnpLabs/rad-domain-event)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KnpLabs/rad-domain-event/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KnpLabs/rad-domain-event/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/knplabs/rad-domain-event/v/stable)](https://packagist.org/packages/knplabs/rad-domain-event) [![Total Downloads](https://poser.pugx.org/knplabs/rad-domain-event/downloads)](https://packagist.org/packages/knplabs/rad-domain-event) [![Latest Unstable Version](https://poser.pugx.org/knplabs/rad-domain-event/v/unstable)](https://packagist.org/packages/knplabs/rad-domain-event) [![License](https://poser.pugx.org/knplabs/rad-domain-event/license)](https://packagist.org/packages/knplabs/rad-domain-event)

A lightweight domain event pattern implementation for Doctrine2.

# Official maintainers:

* [@AntoineLelaisant](https://github.com/AntoineLelaisant)
* [@PedroTroller](https://github.com/PedroTroller)

## Installation

With composer :
```bash
$ composer require knplabs/rad-domain-event
```

If you are using Symfony you can update your `app/AppKernel.php` file:

```php
public function registerBundles()
{
    $bundles = array(
        // bundles here ...
        new Knp\Rad\DomainEvent\Bundle\DomainEventBundle();
    );
}
```

## Usage

### Setup your entity

First, make sure your entity implements the [Provider](./src/Knp/Rad/DomainEvent/Provider.php) interface and uses the [ProviderTrait](./src/Knp/Rad/DomainEvent/ProviderTrait.php).
```php
use Knp\Rad\DomainEvent;

class MyEntity implements DomainEvent\Provider
{
    use DomainEvent\ProviderTrait;
}
```

### Raise event 
Trigger any event from your entity, through the `raise` method.
It will be turned into a [Knp\Rad\DomainEvent\Event](./src/Knp/Rad/DomainEvent/Event.php) object and dispatched once your entity has been flushed. 
```php
use Knp\Rad\DomainEvent;

class MyEntity implements DomainEvent\Provider
{
    // ...
    public function myFunction($arg) {
        // your function behavior
        $this->raise('myEventName', ['anyKey' => $anyValue]);
    }
}
```
### Listen to this event
```php
use Knp\Rad\DomainEvent\Event;

class MyListener
{
    public function onMyEventName(Event $event) {
        // your function behavior     
    }
}
```
Then, of course, register your listener.
```yaml
app.event_listener.my_event_listener:
    class: App\EventListener\MyEventListener
    tags:
        - { name: kernel.event_listener, event: myEventName, method: 'onMyEventName' }
```
