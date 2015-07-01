<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\Article;
use Doctrine\ORM\Mapping as ORM;

/**
 * Announcement
 *
 * @ORM\Table(name="announcement")
 * @ORM\Entity
 */
class Announcement extends Article
{
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
}
