<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NGS\ContentBundle\Entity\Articles;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ArticleType
 *
 * @ORM\Table(name="article_type")
 * @ORM\Entity
 */
class ArticleType
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
