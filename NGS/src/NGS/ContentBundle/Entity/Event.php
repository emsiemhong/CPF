<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\BaseArticle;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event extends BaseArticle
{
    /**
     * @ORM\Column(name="date", type="date")
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
        return 'uploads/events';
    }
}
