<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Substance
 *
 * @ORM\Table(name="substance")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubstanceRepository")
 */
class Substance
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Speciality", inversedBy="substances",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $speciality;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="fullUnit", type="string", length=255, nullable=true)
     */
    private $fullUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="unit1", type="string", length=255, nullable=true)
     */
    private $unit1;

    /**
     * @var string
     *
     * @ORM\Column(name="unit2", type="string", length=255, nullable=true)
     */
    private $unit2;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="CAS", type="string", length=255, nullable=true)
     */
    private $cAS;


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
     * @return Substance
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
     * Set fullUnit
     *
     * @param string $fullUnit
     *
     * @return Substance
     */
    public function setFullUnit($fullUnit)
    {
        $this->fullUnit = $fullUnit;

        return $this;
    }

    /**
     * Get fullUnit
     *
     * @return string
     */
    public function getFullUnit()
    {
        return $this->fullUnit;
    }

    /**
     * Set unit1
     *
     * @param string $unit1
     *
     * @return Substance
     */
    public function setUnit1($unit1)
    {
        $this->unit1 = $unit1;

        return $this;
    }

    /**
     * Get unit1
     *
     * @return string
     */
    public function getUnit1()
    {
        return $this->unit1;
    }

    /**
     * Set unit2
     *
     * @param string $unit2
     *
     * @return Substance
     */
    public function setUnit2($unit2)
    {
        $this->unit2 = $unit2;

        return $this;
    }

    /**
     * Get unit2
     *
     * @return string
     */
    public function getUnit2()
    {
        return $this->unit2;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Substance
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
     * Set cAS
     *
     * @param string $cAS
     *
     * @return Substance
     */
    public function setCAS($cAS)
    {
        $this->cAS = $cAS;

        return $this;
    }

    /**
     * Get cAS
     *
     * @return string
     */
    public function getCAS()
    {
        return $this->cAS;
    }

    /**
     * @return mixed
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * @param mixed $speciality
     */
    public function setSpeciality(Speciality $speciality)
    {
        $this->speciality = $speciality;
    }
}

