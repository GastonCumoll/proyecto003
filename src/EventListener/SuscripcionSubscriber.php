<?php

namespace App\EventListener;

use Twig\Environment;
use PhpParser\Comment;
use Doctrine\ORM\Events;
use App\Entity\Suscripcion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Notifier\NotifierInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;


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

        
    }


}