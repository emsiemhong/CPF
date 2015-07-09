<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\BaseArticle;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event extends BaseArticle
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * Set date
     * @param DateTime $date
     * @return Event
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
        return 'uploads/events';
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }
}
