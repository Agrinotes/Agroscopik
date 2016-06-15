<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Table(name="action")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActionRepository")
 */
class Action
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->periods = new ArrayCollection();
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CropCycle", inversedBy="actions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cropCycle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Intervention", inversedBy="actions",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $intervention;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Event", mappedBy="action", cascade={"persist","remove"})
     */
    private $periods;

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->intervention->getName();
    }

    /**
     * Set cropCycle
     *
     * @param \AppBundle\Entity\CropCycle $cropCycle
     * @return Action
     */
    public function setCropCycle(CropCycle $cropCycle)
    {
        $this->cropCycle = $cropCycle;

        return $this;
    }

    /**
     * Get cropCycle
     *
     * @return \AppBundle\Entity\CropCycle
     */
    public function getCropCycle()
    {
        return $this->cropCycle;
    }

    /**
     * Set intervention
     *
     * @param \AppBundle\Entity\Intervention $intervention
     * @return Action
     */
    public function setIntervention(Intervention $intervention)
    {
        $this->intervention = $intervention;

        $intervention->addAction($this);

        return $this;
    }

    /**
     * Get intervention
     *
     * @return \AppBundle\Entity\Intervention
     */
    public function getIntervention()
    {
        return $this->intervention;
    }

    /**
     * Add period
     *
     * @param \AppBundle\Entity\Event $period
     * @return Action
     */
    public function addPeriod(Event $period)
    {
        $this->periods[] = $period;

        // We also add the current action to the period
        $period->setAction($this);

        return $this;
    }

    /**
     * Remove period
     *
     * @param \AppBundle\Entity\Event $period
     */
    public function removePeriod(Event $period)
    {
        $this->periods->removeElement($period);

        // I should do something here to remove the Event $period from the database
    }

    /**
     * Get action
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPeriods()
    {
        return $this->periods;
    }

    /**
     * Get progress
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProgress()
    {

        $completed_actions = 0;
        $count_actions = 0;

        foreach($this->periods as $period){

            if($period->getStatus()  == "CompletedAction"){
                $completed_actions++;
            }

            $count_actions++;
        }

        return array('completed_actions' => $completed_actions, 'count_actions' => $count_actions);
    }
}

