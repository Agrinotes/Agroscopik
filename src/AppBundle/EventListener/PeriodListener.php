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

            // Update action
            $action = $entity->getAction();
            $periods = $action->getPeriods();

            // Setting StartDatetime
            $action->updateStartDatetime();

            // Setting EndDatetime
            $action->updateEndDatetime();

            $em->persist($action);
            $md = $em->getClassMetadata('AppBundle\Entity\Action');
            $uow->recomputeSingleEntityChangeSet($md, $action);

            // Update cropCycle
            $cycle = $action->getCropCycle();

            // Setting StartDatetime
            $cycle->updateStartDatetime();

            // Setting EndDatetime
            $cycle->updateEndDatetime();
            $em->persist($cycle);

            $meta = $em->getClassMetadata('AppBundle\Entity\CropCycle');
            $uow->recomputeSingleEntityChangeSet($meta, $cycle);
        }
    }
}