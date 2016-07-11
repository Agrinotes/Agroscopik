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
     * @var int
     *
     * @ORM\Column(name="usage_id", type="integer", nullable=true)
     */
    private $usageId;

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
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean", length=255, nullable=true)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="dose", type="float", nullable=true)
     */
    private $dose;

    /**
     * @var string
     *
     * @ORM\Column(name="doseUnit", type="string", length=255, nullable=true)
     */
    private $doseUnit;

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
     * Set usageId
     *
     * @param integer $usageId
     *
     * @return SpecialityUsage
     */
    public function setUsageId($usageId)
    {
        $this->usageId = $usageId;

        return $this;
    }

    /**
     * Get usageId
     *
     * @return int
     */
    public function getUsageId()
    {
        return $this->usageId;
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
     * Set status
     *
     * @param string $status
     *
     * @return SpecialityUsage
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
     * Set doseUnit
     *
     * @param string $doseUnit
     *
     * @return SpecialityUsage
     */
    public function setDoseUnit($doseUnit)
    {
        $this->doseUnit = $doseUnit;

        return $this;
    }

    /**
     * Get doseUnit
     *
     * @return string
     */
    public function getDoseUnit()
    {
        return $this->doseUnit;
    }

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
}

