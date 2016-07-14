<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FarmSpeciality
 *
 * @ORM\Table(name="farm_speciality")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FarmSpecialityRepository")
 */
class FarmSpeciality
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Farm", inversedBy="farmSpecialities",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $farm;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Speciality", inversedBy="farmSpecialities",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $speciality;

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
     * Set farm
     *
     * @param \AppBundle\Entity\Farm $farm
     * @return \AppBundle\Entity\FarmSpeciality
     */
    public function setFarm(Farm $farm)
    {
        $this->farm = $farm;

        return $this;
    }

    /**
     * Get farm
     *
     * @return \AppBundle\Entity\FarmSpeciality
     */
    public function getFarm()
    {
        return $this->farm;
    }

    /**
     * Set speciality
     *
     * @param \AppBundle\Entity\Speciality $speciality
     * @return \AppBundle\Entity\FarmSpeciality
     */
    public function setSpeciality(Speciality $speciality)
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * Get farm
     *
     * @return \AppBundle\Entity\FarmSpeciality
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }
}

