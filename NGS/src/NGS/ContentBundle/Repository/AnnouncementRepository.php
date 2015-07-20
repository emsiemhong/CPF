<?php

namespace NGS\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * AnnouncementRepository
 */
class AnnouncementRepository extends EntityRepository
{

    /**
     * Find all announcements which date bigger than current date
     * Limit max 3 record
     */
    public function findAllAvailable()
    {
        $qb = $this
            ->createQueryBuilder('an')
            ->setFirstResult(0)
            ->setMaxResults(3)
            ->where('an.date >= :current')
            ->setParameter('current', new \DateTime());

        return $qb->getQuery()->getResult();
    }
}
