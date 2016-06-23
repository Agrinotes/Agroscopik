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

            // Get action
            $action = $entity->getAction();

            // Update action StartDatetime
            $action->updateStartDatetime();

            // Update action EndDatetime
            $action->updateEndDatetime();

            $em->persist($action);
            $md = $em->getClassMetadata('AppBundle\Entity\Action');
            $uow->recomputeSingleEntityChangeSet($md, $action);

            // Get cropCycle
            $cycle = $action->getCropCycle();

            // Update action StartDatetime
            $cycle->updateStartDatetime();

            // Update action EndDatetime
            $cycle->updateEndDatetime();

            $em->persist($cycle);

            $meta = $em->getClassMetadata('AppBundle\Entity\CropCycle');
            $uow->recomputeSingleEntityChangeSet($meta, $cycle);
        }
    }
}