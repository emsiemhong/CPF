<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\Article;
use Doctrine\ORM\Mapping as ORM;

/**
 * About
 *
 * @ORM\Table(name="about")
 * @ORM\Entity
 */
class About extends Article
{
    protected function getUploadDir()
    {
        return 'uploads/abouts';
    }
}
