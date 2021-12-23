<?php

namespace App\EventListener;

use DateTime;
use App\Entity\Log;
use App\Entity\User;
use Doctrine\ORM\Events;
use App\Entity\Publicacion;
use App\Entity\Suscripcion;
use App\Entity\TipoPublicacion;
use App\Repository\LogRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\OnFlushEventArgs;
use App\Repository\PublicacionRepository;
use App\Repository\SuscripcionRepository;
use App\Repository\TipoPublicacionRepository;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;


class SuscripcionSubscriber implements EventSubscriberInterface
{
    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::onFlush,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        //aca la logica de enviar mail
        //$args= la entidad
    }
    /**
     * @param OnFlushEventArgs $eventArgs
     */
    public function onFlush(OnFlushEventArgs $eventArgs)
    {   
        $em=$eventArgs->getEntityManager();
        
        $uow=$em->getUnitOfWork();
        //dd($uow->getScheduledEntityInsertions());
        foreach($uow->getScheduledEntityInsertions() as $entity){
            if($entity instanceof Suscripcion){
                $log = new Log();
                $log->setTipoOperacion("Suscripcion");
                $today= new DateTime();
                $log->setFechaYHora($today);
                $log->setPublicacion($entity->getPublicacion()->getTipoPublicacion()->getNombre());
                $log->setUsuario($entity->getUsuario()->getEmail());
                $em->persist($log);
                $uow->computeChangeSet($em->getClassMetadata(get_class($log)), $log);
                }
        }
        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            if($entity instanceof Suscripcion){
                $log = new Log();
                $log->setTipoOperacion("Desuscripcion");
                $today= new DateTime();
                $log->setFechaYHora($today);
                $log->setPublicacion($entity->getPublicacion()->getTipoPublicacion()->getNombre());
                $log->setUsuario($entity->getUsuario()->getEmail());
                $em->persist($log);
                $uow->computeChangeSet($em->getClassMetadata(get_class($log)), $log);
                }
        }
    }
}