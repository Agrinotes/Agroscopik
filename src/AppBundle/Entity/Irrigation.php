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
     * @var float
     *
     * @ORM\Column(name="volume", type="float", nullable=true)
     */
    private $volume;


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
}

