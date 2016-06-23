<?php

namespace AppBundle\Entity;

use DateInterval;
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
        $this->tractors = new ArrayCollection();
        $this->implements = new ArrayCollection();
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
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tractor",inversedBy="actions" ,cascade={"persist"})
     */
    private $tractors;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Implement",inversedBy="actions" ,cascade={"persist"})
     */
    private $implements;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDatetime", type="datetime")
     */
    private $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDatetime", type="datetime")
     */
    private $endDatetime;


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
     * Add tractor
     *
     * @param \AppBundle\Entity\Tractor $tractor
     * @return Action
     */
    public function addTractor(Tractor $tractor)
    {
        $this->tractors[] = $tractor;

        // We also add the current action to the tractor
        $tractor->addAction($this);

        return $this;
    }

    /**
     * Remove tractor
     *
     * @param \AppBundle\Entity\Tractor $tractor
     */
    public function removeTractor(Tractor $tractor)
    {
        $this->tractors->removeElement($tractor);

        $tractor->removeAction($this); // Should be verified

    }

    /**
     * Get tractors
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTractors()
    {
        return $this->tractors;
    }

    /**
     * Add implement
     *
     * @param \AppBundle\Entity\Implement $implement
     * @return Action
     */
    public function addImplement(Implement $implement)
    {
        $this->implements[] = $implement;

        // We also add the current action to the implement
        $implement->addAction($this);

        return $this;
    }

    /**
     * Remove implement
     *
     * @param \AppBundle\Entity\Implement $implement
     */
    public function removeImplement(Implement $implement)
    {
        $this->implements->removeElement($implement);

        $implement->removeAction($this); // Should be verified

    }

    /**
     * Get implements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImplements()
    {
        return $this->implements;
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

    /**
     * Set startDatetime
     *
     * @param \DateTime $startDatetime
     *
     * @return Event
     */
    public function setStartDatetime($startDatetime)
    {
        $this->startDatetime = $startDatetime;

        return $this;
    }

    /**
     * Get startDatetime
     *
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        return $this->startDatetime;
    }

    /**
     * Set endDatetime
     *
     * @param \DateTime $endDatetime
     *
     * @return Event
     */
    public function setEndDatetime($endDatetime)
    {
        $this->endDatetime = $endDatetime;

        return $this;
    }

    /**
     * Get endDatetime
     *
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        return $this->endDatetime;
    }

    public function updateStartDatetime(){
        $periods = $this->getPeriods();
        $i = 0;
        foreach($periods as $period){
            if($i == 0){
                $earliest = $period->getStartDatetime();
                $i++;
            }else{
                if($period->getStartDatetime()< $earliest){
                    $earliest = $period->getStartDatetime();
                }
            }
        }
        $this->setStartDatetime($earliest);
    }

    public function updateEndDatetime(){
        $periods = $this->getPeriods();
        $i = 0;
        foreach($periods as $period){
            if($i == 0){
                $oldest = $period->getEndDatetime();
                $i++;
            }else{
                if($period->getEndDatetime()> $oldest){
                    $oldest = $period->getEndDatetime();
                }
            }
        }
        $this->setEndDatetime($oldest);
    }

    /**
     * Get status
     *
     */
    public function getStatus()
    {
        $now = new \DateTime('now');

        if ($now > $this->endDatetime) {
            return 'CompletedAction';
        } elseif ($now >= $this->startDatetime && $now <= $this->endDatetime) {
            return 'ActiveAction';
        } elseif ($now < $this->startDatetime) {
            return 'PotentialAction';
        }
    }

    /**
     * Get duration
     *
     */
    public function getDuration(){
        $diff  = $this->endDatetime->diff($this->startDatetime);
        $duration = $this->format_interval($diff);

        return $duration;
    }

    /**
     * Format an interval to show all existing components.
     *
     * @param DateInterval $interval The interval
     *
     * @return string Formatted interval string.
     */
    function format_interval(DateInterval $interval) {
        $result = "";

        // Years
        if ($interval->y) {
            if($interval->y == 1){
                $result .= $interval->format("%y an ");
            }else{
                $result .= $interval->format("%y ans ");
            }
        }

        // Months
        if ($interval->m) {
            $result .= $interval->format("%m mois ");
        }

        // Days
        if ($interval->d) {
            if($interval->d == 1){
                $result .= $interval->format("%d jour ");
            }else{
                $result .= $interval->format("%d jours ");
            }
        }

        // Hours
        if ($interval->h) {
            $result .= $interval->format("%hh");
        }

        // Minutes
        if ($interval->i) {
            $result .= $interval->format("%im ");
        }

        return $result;
    }

    public function getIntervalLabel(){
        $start = $this->startDatetime->format('U');
        $end = $this->endDatetime->format('U');

        $startDay = date('d',$start);
        $startMonth = date('F',$start);
        $startYear = date('Y',$start);

        $endDay = date('d',$end);
        $endMonth = date('F',$end);
        $endYear = date('Y',$end);

        //For different years
        if($startYear < $endYear){
            $label = "".$startDay."/".$startMonth."/".$startYear." au ".$endDay."/".$endMonth."/".$endYear;
        }elseif($startMonth < $endMonth){
            // For different months years
            $label = "".$startDay." ".$startMonth." au ".$endDay." ".$endMonth." ".$endYear;
        }elseif($startDay < $endDay){
            // For different days
            $label = "".$startDay." au ".$endDay." ".$endMonth." ".$endYear;
        }else{
            $label = "".$startDay." ".$startMonth." ".$startYear;
        }

        $english = array('January','February','March','April','May','June','July','August','September','October','November','December');
        $french = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');

        $label = str_replace($english, $french, $label);

        return $label;
    }

}

