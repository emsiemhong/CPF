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
     */
    public function findAllAvailable()
    {
        $qb = $this
            ->createQueryBuilder('e')
            ->where('e.date >= :current')
            ->setParameter('current', new \DateTime());

        return $qb->getQuery()->getResult();
    }
}
