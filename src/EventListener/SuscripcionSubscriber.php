<?php

namespace App\EventListener;

use App\Entity\Suscripcion;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class SuscripcionSubscriber implements EventSubscriberInterface
{
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }
    public function postPersist(LifecycleEventArgs $args): void
    {
        //aca la logica de enviar mail
        //$args= la entidad
        dd($args);


        

    }


}