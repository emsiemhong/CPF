<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\BaseArticle;
use NGS\ContentBundle\Entity\ArticleType;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="NGS\ContentBundle\Repository\ArticleRepository")
 */
class Article extends BaseArticle
{
    use ORMBehaviors\Translatable\Translatable;

    const ABOUT_TYPE = 1;
    const SERVICE_TYPE = 2;
    const HOME_TYPE = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_id")
     */
    private $type;

    public function __construct()
    {
        $this->type = self::ABOUT_TYPE;
    }

    protected function getUploadDir()
    {
        return 'uploads/articles';
    }

    /**
     * Set Type
     *
     * @param integer $type
     * @return Article
     */
    public function setType($type)
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

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
