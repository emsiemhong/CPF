<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class Article
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @ORM\Column(nullable=true)
     */
    public $picturePath;

    /**
     * @Assert\Image(maxSize="2Mi")
     */
    private $picture;


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
     * Set title
     *
     * @param string $title
     * @return Article
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set picturePath
     *
     * @param string $picturePath
     * @return EventPageExContentBlock
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
     * @return EventPageExContentBlock
     */
    public function setPicture(UploadedFile $picture)
    {
        $this->picture = $picture;

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
    * Uploads the picture referenced by the picture property
    * Sets the picture path property and resets the picture property
    */
    public function uploadPicture()
    {
        // the file property can be empty if the field is not required
        if (null === $this->picture) {
            return;
        }

        $path = rand(1, 99999).'.'.$this->picture->getClientOriginalName();

        $this->picture->move(
            $this->getUploadRootDir(),
            $path)
        ;

        $this->picturePath = $path;

        // clean up the file property as you won't need it anymore
        $this->picture = null;
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
