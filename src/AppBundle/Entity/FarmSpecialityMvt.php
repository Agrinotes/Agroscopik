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
     * @var float
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=255, nullable=true)
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
}

