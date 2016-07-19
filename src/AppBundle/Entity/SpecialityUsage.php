<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialityUsage
 *
 * @ORM\Table(name="speciality_usage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SpecialityUsageRepository")
 */
class SpecialityUsage
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Speciality", inversedBy="usages",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $speciality;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="minCropStage", type="integer", nullable=true)
     */
    private $minCropStage;

    /**
     * @var int
     *
     * @ORM\Column(name="maxCropStage", type="integer", nullable=true)
     */
    private $maxCropStage;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="dose", type="float", nullable=true)
     */
    private $dose;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $unit1;

    /**
     * @var int
     *
     * @ORM\Column(name="amountUnit2", type="integer", nullable=true)
     */
    private $amountUnit2;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     * @ORM\JoinColumn(nullable=true)
     */
    private $unit2;

    /**
     * @var string
     *
     * @ORM\Column(name="fullUnit", type="string", length=255, nullable=true)
     */
    private $fullUnit;



    /**
     * @var int
     *
     * @ORM\Column(name="DAR", type="integer", nullable=true)
     */
    private $dAR;

    /**
     * @var int
     *
     * @ORM\Column(name="maxActions", type="integer", nullable=true)
     */
    private $maxActions;

    /**
     * @var string
     *
     * @ORM\Column(name="conditions", type="string", length=255, nullable=true)
     */
    private $conditions;

    /**
     * @var int
     *
     * @ORM\Column(name="ZNTwater", type="integer", nullable=true)
     */
    private $zNTwater;

    /**
     * @var int
     *
     * @ORM\Column(name="ZNTarthropodes", type="integer", nullable=true)
     */
    private $zNTarthropodes;

    /**
     * @var int
     *
     * @ORM\Column(name="ZNTplants", type="integer", nullable=true)
     */
    private $zNTplants;


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
     * @return SpecialityUsage
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
     * Set minCropStage
     *
     * @param integer $minCropStage
     *
     * @return SpecialityUsage
     */
    public function setMinCropStage($minCropStage)
    {
        $this->minCropStage = $minCropStage;

        return $this;
    }

    /**
     * Get minCropStage
     *
     * @return int
     */
    public function getMinCropStage()
    {
        return $this->minCropStage;
    }

    /**
     * Set maxCropStage
     *
     * @param integer $maxCropStage
     *
     * @return SpecialityUsage
     */
    public function setMaxCropStage($maxCropStage)
    {
        $this->maxCropStage = $maxCropStage;

        return $this;
    }

    /**
     * Get maxCropStage
     *
     * @return int
     */
    public function getMaxCropStage()
    {
        return $this->maxCropStage;
    }


    /**
     * Set dose
     *
     * @param float $dose
     *
     * @return SpecialityUsage
     */
    public function setDose($dose)
    {
        $this->dose = $dose;

        return $this;
    }

    /**
     * Get dose
     *
     * @return float
     */
    public function getDose()
    {
        return $this->dose;
    }

    /**




    /**
     * Set dAR
     *
     * @param integer $dAR
     *
     * @return SpecialityUsage
     */
    public function setDAR($dAR)
    {
        $this->dAR = $dAR;

        return $this;
    }

    /**
     * Get dAR
     *
     * @return int
     */
    public function getDAR()
    {
        return $this->dAR;
    }

    /**
     * Set maxActions
     *
     * @param integer $maxActions
     *
     * @return SpecialityUsage
     */
    public function setMaxActions($maxActions)
    {
        $this->maxActions = $maxActions;

        return $this;
    }

    /**
     * Get maxActions
     *
     * @return int
     */
    public function getMaxActions()
    {
        return $this->maxActions;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return SpecialityUsage
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set zNTwater
     *
     * @param integer $zNTwater
     *
     * @return SpecialityUsage
     */
    public function setZNTwater($zNTwater)
    {
        $this->zNTwater = $zNTwater;

        return $this;
    }

    /**
     * Get zNTwater
     *
     * @return int
     */
    public function getZNTwater()
    {
        return $this->zNTwater;
    }

    /**
     * Set zNTarthropodes
     *
     * @param integer $zNTarthropodes
     *
     * @return SpecialityUsage
     */
    public function setZNTarthropodes($zNTarthropodes)
    {
        $this->zNTarthropodes = $zNTarthropodes;

        return $this;
    }

    /**
     * Get zNTarthropodes
     *
     * @return int
     */
    public function getZNTarthropodes()
    {
        return $this->zNTarthropodes;
    }

    /**
     * Set zNTplants
     *
     * @param integer $zNTplants
     *
     * @return SpecialityUsage
     */
    public function setZNTplants($zNTplants)
    {
        $this->zNTplants = $zNTplants;

        return $this;
    }

    /**
     * Get zNTplants
     *
     * @return int
     */
    public function getZNTplants()
    {
        return $this->zNTplants;
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
    public function setSpeciality($speciality)
    {
        $this->speciality = $speciality;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getUnit1()
    {
        return $this->unit1;
    }

    /**
     * @param mixed $unit1
     */
    public function setUnit1($unit1)
    {
        $this->unit1 = $unit1;
    }

    /**
     * @return mixed
     */
    public function getUnit2()
    {
        return $this->unit2;
    }

    /**
     * @param mixed $unit2
     */
    public function setUnit2($unit2)
    {
        $this->unit2 = $unit2;
    }

    /**
     * @return int
     */
    public function getAmountUnit2()
    {
        return $this->amountUnit2;
    }

    /**
     * @param int $amountUnit2
     */
    public function setAmountUnit2($amountUnit2)
    {
        $this->amountUnit2 = $amountUnit2;
    }

    /**
     * @return string
     */
    public function getFullUnit()
    {
        return $this->fullUnit;
    }

    /**
     * @param string $fullUnit
     */
    public function setFullUnit($fullUnit)
    {
        $this->fullUnit = $fullUnit;
    }


}

