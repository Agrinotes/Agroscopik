<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FarmSpecialityMvt
 *
 * @ORM\Table(name="farm_speciality_mvt")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FarmSpecialityMvtRepository")
 */
class FarmSpecialityMvt
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FarmSpecialityMvtCategory", inversedBy="movements",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FarmSpeciality", inversedBy="movements",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $speciality;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     */
    private $unit;

    /**
     * @var float
     *
     * @ORM\Column(name="pricePerUnit", type="float", nullable=true)
     */
    private $pricePerUnit;


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
     * Set category
     *
     * @param \AppBundle\Entity\FarmSpecialityMvtCategory $category
     * @return FarmSpecialityMvt
     */
    public function setCategory(FarmSpecialityMvtCategory $category)
    {
        $this->category = $category;

        // Bidirectionnality
        $category->addMovement($this);

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\FarmSpecialityMvt
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set speciality
     *
     * @param \AppBundle\Entity\FarmSpeciality $speciality
     * @return FarmSpecialityMvt
     */
    public function setSpeciality(FarmSpeciality $speciality)
    {
        $this->speciality = $speciality;

        // Bidirectionnality
        $speciality->addMovement($this);

        return $this;
    }

    /**
     * Get speciality
     *
     * @return \AppBundle\Entity\FarmSpecialityMvt
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return Event
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return FarmSpecialityMvt
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set unit
     *
     * @param string $unit
     *
     * @return FarmSpecialityMvt
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set pricePerUnit
     *
     * @param float $pricePerUnit
     *
     * @return FarmSpecialityMvt
     */
    public function setPricePerUnit($pricePerUnit)
    {
        $this->pricePerUnit = $pricePerUnit;

        return $this;
    }

    /**
     * Get pricePerUnit
     *
     * @return float
     */
    public function getPricePerUnit()
    {
        return $this->pricePerUnit;
    }

    /**
     * Get stock
     *
     */
    public function getValue()
    {
        $value = $this->getAmount() * $this->getPricePerUnit();

        return $value;
    }
}

