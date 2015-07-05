<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name = "article_type_translation")
 * @ORM\Entity
 */
class ArticleTypeTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * Set name
     *
     * @param string $name
     * @return ArticleType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this->translatable;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
