<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(
     *      targetEntity="NGS\ContentBundle\Entity\Article",
     *      inversedBy="type",
     *      cascade={"persist", "remove"}
     * )
     */
    private $article;

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
