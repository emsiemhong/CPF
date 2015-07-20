<?php

namespace NGS\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SectionRepository
 */
class SectionRepository extends EntityRepository
{

    /**
     * Find all sections, max 3 records
     */
    public function findAllAvailable()
    {
        $qb = $this
            ->createQueryBuilder('s')
            ->setFirstResult(0)
            ->setMaxResults(3);

        return $qb->getQuery()->getResult();
    }
}
