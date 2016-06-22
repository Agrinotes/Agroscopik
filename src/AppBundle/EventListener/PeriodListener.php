<?php

namespace AppBundle\EventListener;

use AppBundle\Entity\Action;
use AppBundle\Entity\Event;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\Validator\Constraints\DateTime;

class PeriodListener
{
    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        $entities = array_merge(
            $uow->getScheduledEntityInsertions(),
            $uow->getScheduledEntityUpdates()
        );

        foreach ($entities as $entity) {
            if (!($entity instanceof Event)) {
                continue;
            }

            $action = $entity->getAction();
            $action->setStartDatetime($entity->getStartDatetime());
            $action->setEndDatetime($entity->getEndDatetime());

            $em->persist($action);
            $md = $em->getClassMetadata('AppBundle\Entity\Action');
            $uow->recomputeSingleEntityChangeSet($md, $action);
        }
    }
}