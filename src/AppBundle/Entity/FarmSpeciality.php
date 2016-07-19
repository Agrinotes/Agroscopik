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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FarmSpecialityMvt", mappedBy="speciality", cascade={"persist","remove"})
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

    /**
     * Add movement
     *
     * @param \AppBundle\Entity\FarmSpecialityMvt $movement
     * @return FarmSpeciality
     */
    public function addMovement(FarmSpecialityMvt $movement)
    {
        $this->movements[] = $movement;

        return $this;
    }

    /**
     * Remove movement
     *
     * @param \AppBundle\Entity\FarmSpecialityMvt $movement
     */
    public function removeMovement(FarmSpecialityMvt $movement)
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

    /**
     * Get stock
     *
     */
    public function getStock()
    {
        $movements = $this->getMovements();
        $cat = $this->getSpeciality()->getUnitCategory()->getSlug();
        $stock = 0;

        foreach ($movements as $movement) {
            // Get original values
            $unit = $movement->getUnit();
            $rawAmount = $movement->getAmount();

            // Get proper factor
            $factor = $unit->getA();

            if($factor!=0){
                $correctedAmount = $rawAmount/$factor;
            }else{
                $correctedAmount = $rawAmount;
            }
            $stock += $correctedAmount;
        }

        if($cat == "volume"){
            $stock /= 1000;
        }

        return $stock;
    }

    /**
     * Get value
     *
     */
    public function getValue()
    {
        $movements = $this->getMovements();

        $value = 0;

        foreach ($movements as $movement) {
            $value += $movement->getValue();
        }

        return $value;
    }

    public function getUnit(){
        $movements = $this->getMovements();
        $unit="";
        foreach($movements as $movement){
            if($unit == ""){$unit = $movement->getUnit();}
        }
        return $unit;
    }

    /**
     * Get value
     *
     */
    public function getMaxUnitPrice()
    {
        $movements = $this->getMovements();

        $price = 0;

        foreach($movements as $movement){
            if($movement->getPricePerUnit()>$price){
                $price = $movement->getPricePerUnit();
            }
        }

        return $price;
    }
}

