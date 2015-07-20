<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\BaseArticle;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Announcement
 *
 * @ORM\Table(name="announcement")
 * @ORM\Entity(repositoryClass="NGS\ContentBundle\Repository\AnnouncementRepository")
 */
class Announcement extends BaseArticle
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * Set date
     * @param DateTime $date
     * @return Announcement
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    protected function getUploadDir()
    {
        return 'uploads/announcements';
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
