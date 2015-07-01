<?php

namespace NGS\ContentBundle\Entity;

use NGS\ContentBundle\Entity\Article;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * Library
 *
 * @ORM\Table(name="labrary")
 * @ORM\Entity
 */
class Library extends Article
{
    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var boolean
     *
     * @ORM\Column(name="downloadable", type="boolean")
     */
    private $downloadable;

    private $tempFile;

    /**
     * @ORM\Column(nullable=true)
     */
    private $filePath;

    /**
     * @Assert\File(
     *     maxSize = "2Mi",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     */
    private $file;

    /**
     * Set filePath
     *
     * @param string $filePath
     * @return Library
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get filePath
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set file
     *
     * @param UploadedFile $file
     * @return Article
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if (isset($this->filePath)) {
            $this->tempFile = $this->filePath;
            $this->filePath = null;
        } else {
            $this->filePath = 'initial';
        }

        return $this;
    }

    /**
     * Get file
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUploadFile()
    {
        if (null !== $this->file) {
            $path = rand(1, 99999).'.'.$this->file->getClientOriginalName();
            $this->filePath = $path;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadFile()
    {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        $this->file->move(
            $this->getUploadRootDir(),
            $this->filePath)
        ;

        // check if have an old file
        if (isset($this->tempFile)) {
            //delete the old file
            unlink($this->getUploadDir() . '/' . $this->tempFile);
            // clear the temp file path
            $this->tempFile = null;
        }
        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeFileUpload()
    {
        $file = $this->getFileAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }

    /**
    * Gets the absolute directory path to the file
    * @return string path to file
    **/
    public function getFileAbsolutePath()
    {
        return null === $this->filePath
            ? null
            : $this->getUploadRootDir().'/'.$this->filePath;
    }

    /**
    * Gets the relative web path to the file
    * @return string path to file
    **/
    public function getFileWebPath()
    {
        return null === $this->filePath
            ? null
            : $this->getUploadDir().'/'.$this->filePath;
    }

    protected function getUploadDir()
    {
        return 'uploads/libraries';
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Library
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set downloadable
     *
     * @param boolean $downloadable
     * @return Library
     */
    public function setDownloadable($downloadable)
    {
        $this->downloadable = $downloadable;

        return $this;
    }

    /**
     * Get downloadable
     *
     * @return boolean
     */
    public function isDownloadable()
    {
        return $this->downloadable;
    }
}
