<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NGS\ContentBundle\Entity\ContactBooks;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ContactBookSection
 *
 * @ORM\Table(name="contact_book_section")
 * @ORM\Entity
 */
class ContactBookSection
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     * @ORM\OneToMany(
     *      targetEntity="NGS\ContentBundle\Entity\ContactBooks",
     *      mappedBy="section",
     *      cascade={"persist", "remove"}
     * )
     */
    private $contactBooks;

    public function __construct()
    {
        $this->contactBooks = new ArrayCollection();
    }

    /**
     * Get contactBooks
     *
     * @return Collection
     */
    public function getContactBooks()
    {
        return $this->contactBooks;
    }

    /**
     * Add contactBooks
     *
     * @param ContactBooks $contactBooks
     * @return ContactBookSection
     */
     public function addContactBooks(ContactBooks $contactBook)
     {
        $contactBook->setSection($this);
        $this->contactBooks->add($contactBook);

        return $this;
     }

    /**
     * Remove contactBooks
     *
     * @param ContactBooks $contactBooks
     * @return ContactBookSection
     */
    public function removeContactBooks(ContactBooks $contactBook)
    {
        $contactBook->unsetSection();
        $this->contactBooks->removeElement($contactBook);

        return $this;
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
     * Set name
     *
     * @param string $name
     * @return ContactBookSection
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}
