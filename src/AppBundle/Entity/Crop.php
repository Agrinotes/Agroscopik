<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Crop
 *
 * @ORM\Table(name="crop")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CropRepository")
 */
class Crop
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cropCycles = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\CropCycle",mappedBy="crops", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cropCycles;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7, unique=false)
     */
    private $color;

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
     * Set name
     *
     * @param string $name
     *
     * @return Crop
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
     * Add cropCycle
     *
     * @param \AppBundle\Entity\CropCycle $cropCycle
     * @return Crop
     */
    public function addCropCycle(CropCycle $cropCycle)
    {
        $this->cropCycles[] = $cropCycle;

        return $this;
    }

    /**
     * Remove cropCycle
     *
     * @param \AppBundle\Entity\CropCycle $cropCycle
     */
    public function removeCropCycle(CropCycle $cropCycle)
    {
        $this->cropCycles->removeElement($cropCycle);
    }

    /**
     * Get cropCycles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCropCycles()
    {
        return $this->cropCycles;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }
}

