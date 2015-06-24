<?php

namespace Knp\Rad\DomainEvent\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Knp\Rad\DomainEvent\DependencyInjection\DomainEventExtension;

class DomainEventBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new DomainEventExtension();
        }
        return $this->extension;
    }
}
