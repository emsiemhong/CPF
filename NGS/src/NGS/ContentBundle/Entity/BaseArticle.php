<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use NGS\UserBundle\Entity\User;

/*
 * @ORM\HasLifecycleCallbacks
 */
abstract class BaseArticle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    protected $created;

    /**
     * @ORM\ManyToOne(targetEntity="NGS\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="posted_by", referencedColumnName="id")
     */
    protected $postedBy;

    protected $temp;

    /**
     * @ORM\Column(nullable=true)
     */
    public $picturePath;

    /**
     * @Assert\Image(
     *      maxSize="2Mi",
     *      mimeTypesMessage = " This file is not a valid image."
     * )
     */
    private $picture;

    public function __construct()
    {
        $this->created = new \DateTime();
    }

        /**
     * Set PostedBy
     *
     * @param User $user
     * @return Articles
     */
    public function setPostedBy(User $user)
    {
        $this->postedBy = $user;

        return $this;
    }

    /**
     * Get PostedBy
     *
     * @return User
     */
    public function getPostedBy()
    {
        return $this->postedBy;
    }

    /**
     * Set created
     *
     * @param datetime
     * @return BaseArticle
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
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
     * Set picturePath
     *
     * @param string $picturePath
     * @return BaseArticle
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    /**
     * Get picturePath
     *
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picturePath;
    }

    /**
     * Set picture
     *
     * @param UploadedFile $picture
     * @return BaseArticle
     */
    public function setPicture(UploadedFile $picture = null)
    {
        $this->picture = $picture;
        if (isset($this->picturePath)) {
            $this->temp = $this->picturePath;
            $this->picturePath = null;
        } else {
            $this->picturePath = 'initial';
        }

        return $this;
    }

    /**
     * Get picture
     *
     * @return UploadedFile
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->picture) {
            $path = rand(1, 99999).'.'.$this->picture->getClientOriginalName();
            $this->picturePath = $path;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->picture) {
            return;
        }

        $this->picture->move(
            $this->getUploadRootDir(),
            $this->picturePath)
        ;

        // check if have an old image
        if (isset($this->temp)) {
            //delete the old image
            unlink($this->getUploadDir() . '/' . $this->temp);
            // clear the temp image path
            $this->temp = null;
        }
        // clean up the file property as you won't need it anymore
        $this->picture = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $picture = $this->getAbsolutePath();
        if ($picture) {
            unlink($picture);
        }
    }

    /**
    * Gets the absolute directory path to the picture
    * @return string path to picture
    **/
    public function getAbsolutePath()
    {
        return null === $this->picturePath
            ? null
            : $this->getUploadRootDir().'/'.$this->picturePath;
    }

    /**
    * Gets the relative web path to the picture
    * @return string path to picture
    **/
    public function getWebPath()
    {
        return null === $this->picturePath
            ? null
            : $this->getUploadDir().'/'.$this->picturePath;
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/documents';
    }
}
