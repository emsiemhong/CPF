<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\BaseArticle;
use NGS\ContentBundle\Entity\ArticleType;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Articles
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity
 */
class Articles extends BaseArticle
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(
     *      targetEntity="NGS\ContentBundle\Entity\ArticleType",
     *      inversedBy="articles",
     * )
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    private $type;

    protected function getUploadDir()
    {
        return 'uploads/articles';
    }

    /**
     * Set Type
     *
     * @param ArticleType $type
     * @return Articles
     */
    public function setType(ArticleType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Unset Type
     *
     * @return Articles
     */
    public function unsetType()
    {
        unset($this->type);

        return $this;
    }

    /**
     * Get type
     *
     * @return ArticleType
     */
    public function getType()
    {
        return $this->type;
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
