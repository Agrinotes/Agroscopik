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
        $this->substances = new ArrayCollection();
        $this->farmSpecialities = new ArrayCollection();
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
     * @ORM\Column(name="amm", type="integer", nullable=true)
     */
    private $amm;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alternative_name", type="string", length=255, nullable=true, unique=false)
     */
    private $alternativeName;

    /**
     * @var string
     *
     * @ORM\Column(name="owner", type="string", length=255, nullable=true, unique=false)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="authorized_mentions", type="string", length=255, nullable=true, unique=false)
     */
    private $authorizedMentions;

    /**
     * @var string
     *
     * @ORM\Column(name="composition", type="string", length=255, nullable=true, unique=false)
     */
    private $composition;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\SpecialityUsage", mappedBy="speciality", cascade={"persist","remove"})
     */
    private $usages;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Substance", mappedBy="speciality", cascade={"persist","remove"})
     */
    private $substances;

    /**
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\FarmSpeciality", mappedBy="speciality", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $farmSpecialities;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnitCategory")
     * @ORM\JoinColumn(nullable=true)
     */
    private $unitCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="ft", type="text", nullable=true)
     */
    private $ft;

    /**
     * @var string
     *
     * @ORM\Column(name="fds", type="text", nullable=true)
     */
    private $fds;

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

    public function getUsages(){
        return $this->usages;
    }

    /**
     * Add substance
     *
     * @param \AppBundle\Entity\Substance $substance
     * @return Speciality
     */
    public function addSubstance(Substance $substance)
    {
        $this->substances[] = $substance;

        //Bidirectionnality
        $substance->setSpeciality($this);

        return $this;
    }

    /**
     * Remove substance
     *
     * @param \AppBundle\Entity\Substance $substance
     */
    public function removeSubstance(Substance $substance)
    {
        $this->substances->removeElement($substance);

        $substance->setSpeciality(""); // That's a problem because Speciality cannot be null
    }

    /**
     * Get substances
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubstances()
    {
        return $this->substances;
    }




    /**
     * Add farm speciality
     *
     * @param \AppBundle\Entity\FarmSpeciality $speciality
     * @return Speciality
     */
    public function addFarmSpeciality(FarmSpeciality $speciality)
    {
        $this->farmSpecialities[] = $speciality;

        // We also add the current speciality to the farmSpeciality
        $speciality->setSpeciality($this);

        return $this;
    }

    /**
     * Remove farm speciality
     *
     * @param \AppBundle\Entity\FarmSpeciality $speciality
     */
    public function removeFarmSpeciality(FarmSpeciality $speciality)
    {
        $this->farmSpecialities->removeElement($speciality);
    }

    /**
     * Get farm Specialities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFarmSpecialities()
    {
        return $this->farmSpecialities;
    }

    /**
     * @return mixed
     */
    public function getUnitCategory()
    {
        return $this->unitCategory;
    }

    /**
     * @param mixed $unitCategory
     */
    public function setUnitCategory($unitCategory)
    {
        $this->unitCategory = $unitCategory;
    }

    /**
     * @return string
     */
    public function getAlternativeName()
    {
        return $this->alternativeName;
    }

    /**
     * @param string $alternativeName
     */
    public function setAlternativeName($alternativeName)
    {
        $this->alternativeName = $alternativeName;
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param string $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return string
     */
    public function getAuthorizedMentions()
    {
        return $this->authorizedMentions;
    }

    /**
     * @param string $authorizedMentions
     */
    public function setAuthorizedMentions($authorizedMentions)
    {
        $this->authorizedMentions = $authorizedMentions;
    }

    /**
     * @return string
     */
    public function getComposition()
    {
        return $this->composition;
    }

    /**
     * @param string $composition
     */
    public function setComposition($composition)
    {
        $this->composition = $composition;
    }

    /**
     * @return string
     */
    public function getFt()
    {
        return $this->ft;
    }

    /**
     * @param string $ft
     */
    public function setFt($ft)
    {
        $this->ft = $ft;
    }

    /**
     * @return string
     */
    public function getFds()
    {
        return $this->fds;
    }

    /**
     * @param string $fds
     */
    public function setFds($fds)
    {
        $this->fds = $fds;
    }
}

