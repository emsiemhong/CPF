<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use NGS\UserBundle\Entity\User;

/**
 * @ORM\Table(name = "articles_translation")
 * @ORM\Entity
 */
class ArticlesTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * Set title
     *
     * @param string $title
     * @return Articles
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this->translatable;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Articles
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this->translatable;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
