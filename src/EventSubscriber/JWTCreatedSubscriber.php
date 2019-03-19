<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JWTCreatedSubscriber implements EventSubscriberInterface
{
    public function onJwtCreatedEvent(JWTCreatedEvent $event)
    {
        $payload       = $event->getData();
        $payload['id'] = $event->getUser()->getId();

        $event->setData($payload);
    }

    public static function getSubscribedEvents()
    {
        return [Events::JWT_CREATED => 'onJwtCreatedEvent'];
    }
}
