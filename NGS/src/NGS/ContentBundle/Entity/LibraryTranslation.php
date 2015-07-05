<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name = "library_translation")
 * @ORM\Entity
 */
class LibraryTranslation
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
     * @ORM\ManyToOne(targetEntity="NGS\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="posted_by", referencedColumnName="id")
     */
    protected $postedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * Set PostedBy
     *
     * @param User $user
     * @return Library
     */
    public function setPostedBy(User $user)
    {
        $this->postedBy = $user;

        return $this->translatable;
    }

    /**
     * Get PostedBy
     *
     * @return User
     */
    public function getPostedBy()
    {
        return $this->postedBy;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Library
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
     * @return Library
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

    /**
     * Set author
     *
     * @param string $author
     * @return Library
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this->translatable;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }
}