<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Irrigation
 *
 * @ORM\Table(name="irrigation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\IrrigationRepository")
 */
class Irrigation
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Action", inversedBy="irrigations", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @var float
     *
     * @ORM\Column(name="duration", type="float", nullable=true)
     */
    private $duration;

    /**
     * @var float
     *
     * @ORM\Column(name="flow", type="float", nullable=true)
     */
    private $flow;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     */
    private $flowUnit;

    /**
     * @var float
     *
     * @ORM\Column(name="volume", type="float", nullable=true)
     */
    private $volume;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     */
    private $volumeUnit;


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
     * Set action
     *
     * @param \AppBundle\Entity\Action $action
     * @return Irrigation
     */
    public function setAction(Action $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \AppBundle\Entity\Action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set duration
     *
     * @param float $duration
     *
     * @return Irrigation
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return float
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set flow
     *
     * @param float $flow
     *
     * @return Irrigation
     */
    public function setFlow($flow)
    {
        $this->flow = $flow;

        return $this;
    }

    /**
     * Get flow
     *
     * @return float
     */
    public function getFlow()
    {
        return $this->flow;
    }

    /**
     * Set volume
     *
     * @param float $volume
     *
     * @return Irrigation
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return float
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @return mixed
     */
    public function getFlowUnit()
    {
        return $this->flowUnit;
    }

    /**
     * @param mixed $flowUnit
     */
    public function setFlowUnit($flowUnit)
    {
        $this->flowUnit = $flowUnit;
    }

    /**
     * @return mixed
     */
    public function getVolumeUnit()
    {
        return $this->volumeUnit;
    }

    /**
     * @param mixed $volumeUnit
     */
    public function setVolumeUnit($volumeUnit)
    {
        $this->volumeUnit = $volumeUnit;
    }

    /**
     * @return mixed
     */
    public function getStdAmount()
    {
        if($this->getVolume() && $this->getVolumeUnit()){
            $volume = $this->getVolume();
            $unit = $this->getVolumeUnit();
            $a = $unit->getA();
            $c = $unit->getC();

            $volume*=$a;// To m3
            $volume*=1000; //To Liters
            if($c){
                $volume/=$c; //To m2
            }
            return $volume; // m²/L or mm
        }

        if($this->getFlow()&&$this->getFlowUnit()&&$this->getDuration()){
            $flow = $this->getFlow(); // L/h or m3/h
            $unit =$this->getFlowUnit();
            $a = $unit->getA();
            $c = $unit->getC();

            $flow *= $a; // To m3/h
            $flow *= 1000; // To liters/h

            $flow /= $c; // TO L/second
            $flow *= 60; // To L/minute

            $duration = $this->getDuration(); // In minutes

            $volume = $flow*$duration; // In liters

            $area = $this->getAction()->getCropCycle()->getArea();
            $area *= 10000; //To m²

            $volume = $volume/$area; // L/m² or mm

            return round($volume);
        }

        return "";
    }
}

