<?php

namespace AppBundle\Repository;

/**
 * FarmSpecialityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class FarmSpecialityRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllForCurrentFarm ($id)
    {
        $qb = $this->createQueryBuilder('s');

        $qb->where('s.farm = :farm')
            ->setParameter('farm', $id)
        ;

        return $qb
            ->getQuery()
            ->getResult()
            ;
    }
}