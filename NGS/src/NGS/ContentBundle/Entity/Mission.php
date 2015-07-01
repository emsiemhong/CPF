<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\Article;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mission
 *
 * @ORM\Table(name="mission")
 * @ORM\Entity
 */
class Mission extends Article
{
    protected function getUploadDir()
    {
        return 'uploads/missions';
    }
}
