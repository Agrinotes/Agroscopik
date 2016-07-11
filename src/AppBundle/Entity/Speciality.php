<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Speciality
 *
 * @ORM\Table(name="speciality")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecialityRepository")
 */
class Speciality
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usages = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="amm", type="integer", nullable=true, unique=true)
     */
    private $amm;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SpecialityUsage", mappedBy="speciality", cascade={"persist","remove"})
     */
    private $usages;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set amm
     *
     * @param integer $amm
     *
     * @return Speciality
     */
    public function setAmm($amm)
    {
        $this->amm = $amm;

        return $this;
    }

    /**
     * Get amm
     *
     * @return int
     */
    public function getAmm()
    {
        return $this->amm;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Speciality
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

    /**
     * Add usage
     *
     * @param \AppBundle\Entity\SpecialityUsage $usage
     * @return Speciality
     */
    public function addUsage(SpecialityUsage $usage)
    {
        $this->usages[] = $usage;

        $usage->setSpeciality($this);

        return $this;
    }

    /**
     * Remove usage
     *
     * @param \AppBundle\Entity\SpecialityUsage $usage
     */
    public function removeUsage(SpecialityUsage $usage)
    {
        $this->usages->removeElement($usage);
    }
}

