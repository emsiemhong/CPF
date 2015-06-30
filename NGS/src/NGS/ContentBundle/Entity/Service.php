<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\Article;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="service")
 * @ORM\Entity
 */
class Service extends Article
{
}
