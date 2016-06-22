<?php

namespace AppBundle\Repository;

/**
 * CropRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CropRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByFarm($id)
    {
        $qb = $this->createQueryBuilder('c');

        $qb->join('c.cropCycles', 'cycles')
            ->addSelect('cycles')
            ->join('cycles.plot', 'plots')
            ->addSelect('plots')
            ->join('plots.farm', 'farm')
            ->addSelect('farm')
            ->where('farm.id = :id')
            ->setParameter('id', $id);

        return $qb
            ->getQuery()
            ->getResult();
    }
}