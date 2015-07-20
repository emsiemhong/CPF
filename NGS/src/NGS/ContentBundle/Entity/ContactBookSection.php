<?php

namespace NGS\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use NGS\ContentBundle\Entity\ContactBook;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ContactBookSection
 *
 * @ORM\Table(name="contact_book_section")
 * @ORM\Entity(repositoryClass="NGS\ContentBundle\Repository\SectionRepository")
 */
class ContactBookSection
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     *
     * @Assert\Valid()
     * @ORM\OneToMany(
     *      targetEntity="NGS\ContentBundle\Entity\ContactBook",
     *      mappedBy="section",
     *      cascade={"persist", "remove"}
     * )
     */
    private $contactBook;

    public function __construct()
    {
        $this->contactBook = new ArrayCollection();
    }

    /**
     * Get contactBook
     *
     * @return Collection
     */
    public function getContactBook()
    {
        return $this->contactBook;
    }

    /**
     * Add contactBook
     *
     * @param ContactBook $contactBook
     * @return ContactBookSection
     */
     public function addContactBook(ContactBook $contactBook)
     {
        $contactBook->setSection($this);
        $this->contactBook->add($contactBook);

        return $this;
     }

    /**
     * Remove contactBook
     *
     * @param ContactBook $contactBook
     * @return ContactBookSection
     */
    public function removeContactBook(ContactBook $contactBook)
    {
        $contactBook->unsetSection();
        $this->contactBook->removeElement($contactBook);

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

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __toString()
    {
        return (string) $this->getName();
    }
}
