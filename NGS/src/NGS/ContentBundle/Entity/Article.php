<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\BaseArticle;
use NGS\ContentBundle\Entity\ArticleType;
use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity
 */
class Article extends BaseArticle
{
    /**
     * @ORM\OneToMany(
     *      targetEntity="NGS\ContentBundle\Entity\ArticleType",
     *      mappedBy="article",
     *      cascade={"persist", "remove"}
     * )
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    protected function getUploadDir()
    {
        return 'uploads/articles';
    }

    /**
     * Set type
     *
     * @param ArticleType $type
     * @return Article
     */
    public function setType(ArticleType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }
}
