<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FarmFertilizer
 *
 * @ORM\Table(name="farm_fertilizer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FarmFertilizerRepository")
 */
class FarmFertilizer
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Farm", inversedBy="farmFertilizers",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $farm;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fertilizer", inversedBy="farmFertilizers",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fertilizer;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FarmFertilizerMvt", mappedBy="fertilizer", cascade={"persist","remove"})
     */
    private $movements;

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
     * @return \AppBundle\Entity\FarmFertilizer
     */
    public function setFarm(Farm $farm)
    {
        $this->farm = $farm;

        return $this;
    }

    /**
     * Get farm
     *
     * @return \AppBundle\Entity\FarmFertilizer
     */
    public function getFarm()
    {
        return $this->farm;
    }

    /**
     * Set fertilizer
     *
     * @param \AppBundle\Entity\Fertilizer $fertilizer
     * @return \AppBundle\Entity\FarmFertilizer
     */
    public function setFertilizer(Fertilizer $fertilizer)
    {
        $this->fertilizer = $fertilizer;

        return $this;
    }

    /**
     * Get fertilizer
     *
     * @return \AppBundle\Entity\FarmFertilizer
     */
    public function getFertilizer()
    {
        return $this->fertilizer;
    }



    /**
     * Add movement
     *
     * @param \AppBundle\Entity\FarmFertilizerMvt $movement
     * @return FarmFertilizer
     */
    public function addMovement(FarmFertilizerMvt $movement)
    {
        $this->movements[] = $movement;

        return $this;
    }

    /**
     * Remove movement
     *
     * @param \AppBundle\Entity\FarmFertilizerMvt $movement
     */
    public function removeMovement(FarmFertilizerMvt $movement)
    {
        $this->movements->removeElement($movement);

        $movement->setCategory(""); // That's a problem because its Category cannot be null... Should be resolved soon
    }

    /**
     * Get movements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovements()
    {
        return $this->movements;
    }
}

