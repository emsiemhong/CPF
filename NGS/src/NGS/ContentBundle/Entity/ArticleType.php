<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NGS\ContentBundle\Entity\Articles;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ArticleType
 *
 * @ORM\Table(name="article_type")
 * @ORM\Entity
 */
class ArticleType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     * @ORM\OneToMany(
     *      targetEntity="NGS\ContentBundle\Entity\Articles",
     *      mappedBy="type",
     *      cascade={"persist", "remove"}
     * )
     */
    private $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get articles
     *
     * @return Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Add article
     *
     * @param Article $article
     * @return ArticleType
     */
     public function addArticle(Articles $article)
     {
        $article->setType($this);
        $this->articles->add($article);

        return $this;
     }

    /**
     * Remove article
     *
     * @param Article $article
     * @return ArticleType
     */
    public function removeArticle(Articles $article)
    {
        $article->unsetType();
        $this->articles->removeElement($article);

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ArticleType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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

    public function __toString()
    {
        return (string) $this->getName();
    }
}
