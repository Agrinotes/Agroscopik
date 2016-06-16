<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Farm;

/**
 * Plot
 *
 * @ORM\Table(name="plot")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PlotRepository")
 */
class Plot
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Farm", inversedBy="plots", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $farm;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\CropCycle", mappedBy="plot", cascade={"persist","remove"})
     */
    private $cropCycles;

    /**
     * @var string
     *
     * @ORM\Column(name="latLngs", type="text", nullable=true)
     */
    private $latLngs;

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $area;

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
     * @return Plot
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
     * Set farm
     *
     * @param \AppBundle\Entity\Farm $farm
     * @return Plot
     */
    public function setFarm(Farm $farm)
    {
        $this->farm = $farm;

        return $this;
    }

    /**
     * Get farm
     *
     * @return \AppBundle\Entity\Farm
     */
    public function getFarm()
    {
        return $this->farm;
    }

    /**
     * Add CropCycle
     *
     * @param \AppBundle\Entity\CropCycle $cropCycle
     * @return Plot
     */
    public function addCropCycle(\AppBundle\Entity\CropCycle $cropCycle)
    {
        $this->cropCycles[] = $cropCycle;

        // We also add the current plot to the cropCycle
        $cropCycle->setPlot($this);

        return $this;
    }

    /**
     * Remove CropCycles
     *
     * @param \AppBundle\Entity\CropCycle $cropCycles
     */
    public function removeCropCycle(\AppBundle\Entity\CropCycle $cropCycles)
    {
        $this->cropCycles->removeElement($cropCycles);
    }

    /**
     * Get CropCycles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCropCycles()
    {
        return $this->cropCycles;
    }

    /**
     * Set latLngs
     *
     * @param string $latLngs
     * @return Plot
     */
    public function setLatLngs($latLngs)
    {
        $this->latLngs = $latLngs;

        return $this;
    }

    /**
     * Get latLngs
     *
     * @return string
     */
    public function getLatLngs()
    {
        return $this->latLngs;
    }

    /**
     * Set area
     *
     * @param string $area
     * @return Plot
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }
}

