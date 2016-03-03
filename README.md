# Knp Rad Domain Event
A lightweight domain event implementation for Doctrine2.

## Installation

With composer :
```bash
$ composer require knplabs/rad-domain-event
```

If you are using symfony2 you can update your `app/AppKernel.php` file:

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
        $this->raise('myEventName', ['anyProperty' => $anyValue]);
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
