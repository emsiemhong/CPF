<?php

namespace NGS\ContentBundle\Repository;

use Doctrine\ORM\EntityRepository;
use NGS\ContentBundle\Entity\Article;

/**
 * ArticleRepository
 */
class ArticleRepository extends EntityRepository
{

    public function findAllAboutType()
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->where('a.type = :type')
            ->setParameter('type', Article::ABOUT_TYPE);

        return $qb->getQuery()->getResult();
    }

    public function findAllServiceType()
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->where('a.type = :type')
            ->setParameter('type', Article::SERVICE_TYPE);

        return $qb->getQuery()->getResult();
    }
}
