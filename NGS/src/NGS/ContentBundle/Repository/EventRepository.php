<?php

namespace NGS\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * EventRepository
 */
class EventRepository extends EntityRepository
{

    /**
     * Find all events which date bigger than current date
     * and limit max 3 record
     */
    public function findAllAvailable()
    {
        $qb = $this
            ->createQueryBuilder('e')
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->where('e.date >= :current')
            ->setParameter('current', new \DateTime());

        return $qb->getQuery()->getResult();
    }
}
