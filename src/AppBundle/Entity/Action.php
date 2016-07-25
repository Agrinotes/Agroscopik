<?php

namespace AppBundle\Entity;

use DateInterval;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
        $this->expenses = new ArrayCollection();
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FarmSpecialityMvt", mappedBy="action", cascade={"persist","remove"})
     */
    private $farmSpecialityMvts;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FarmFertilizerMvt", mappedBy="action", cascade={"persist","remove"})
     */
    private $farmFertilizerMvts;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\HarvestProduct", mappedBy="action", cascade={"persist","remove"})
     */
    private $harvestProducts;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var float
     *
     * @ORM\Column(name="density", type="float", nullable=true)
     *
     */
    private $density;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     */
    private $densityUnit;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Insect")
     */
    private $auxiliary;

    /**
     * @var string
     *
     * @ORM\Column(name="aim", type="text", nullable=true)
     */
    private $aim;


    /**
     * @var int
     *
     * @ORM\Column(name="nbWorkers", type="integer", nullable=true)
     */
    private $nbWorkers;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Expense", mappedBy="action", cascade={"persist","remove"})
     */
    private $expenses;

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
     * Add pesticide movement
     *
     * @param \AppBundle\Entity\FarmSpecialityMvt $movement
     * @return Action
     */
    public function addFarmSpecialityMvt(FarmSpecialityMvt $movement)
    {
        $this->farmSpecialityMvts[] = $movement;

        $movement->setAction($this);

        return $this;
    }

    /**
     * Remove pesticide movement
     *
     * @param \AppBundle\Entity\FarmSpecialityMvt $movement
     */
    public function removeFarmSpecialityMvt(FarmSpecialityMvt $movement)
    {
        $this->farmSpecialityMvts->removeElement($movement);

        $movement->setAction("");
    }

    /**
     * Get movements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFarmSpecialityMvts()
    {
        return $this->farmSpecialityMvts;
    }


    /**
     * Add fertilizer movement
     *
     * @param \AppBundle\Entity\FarmFertilizerMvt $movement
     * @return Action
     */
    public function addFarmFertilizerMvt(FarmFertilizerMvt $movement)
    {
        $this->farmFertilizerMvts[] = $movement;

        $movement->setAction($this);

        return $this;
    }

    /**
     * Remove fertilizer movement
     *
     * @param \AppBundle\Entity\FarmFertilizerMvt $movement
     */
    public function removeFarmFertilizerMvt(FarmFertilizerMvt $movement)
    {
        $this->farmFertilizerMvts->removeElement($movement);

        $movement->setAction("");
    }

    /**
     * Get fertilizer movements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFarmFertilizerMvts()
    {
        return $this->farmFertilizerMvts;
    }

    /**
     * Add harvest  product
     *
     * @param \AppBundle\Entity\HarvestProduct $product
     * @return Action
     */
    public function addHarvestProduct(HarvestProduct $product)
    {
        $this->harvestProducts[] = $product;

        //Bidirectionnality
        $product->setAction($this);

        return $this;
    }

    /**
     * Remove harvest product
     *
     * @param \AppBundle\Entity\HarvestProduct $product
     */
    public function removeHarvestProduct(HarvestProduct $product)
    {
        $this->harvestProducts->removeElement($product);

        $product->setAction(""); // That's a problem
    }

    /**
     * Get harvest products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getHarvestProducts()
    {
        return $this->harvestProducts;
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
        $now->add(new DateInterval('PT9H'));


        $start = $this->startDatetime;
        $end = $this->endDatetime;

        if ($now > $end) {
            return 'CompletedAction';
        } elseif ($now >= $start && $now <= $end) {
            return 'ActiveAction';
        } elseif ($now < $start) {
            return 'PotentialAction';
        }
    }

    /**
     * Get duration
     * Loops through associated \Event $periods to get action duration
     */
    public function getDuration(){
        $periods = $this->getPeriods();

        $reference = new DateTimeImmutable;
        $endTime = clone $reference;

        foreach($periods as $period){
$endTime = $endTime->add($period->getDuration());
        }

        return $reference->diff($endTime);
    }

    /**
     * Get duration label
     *
     */
    public function getDurationLabel(){
        $diff  = $this->getDuration();
        $duration = $this->format_duration($diff);

        return $duration;
    }

    /**
     * Format an interval to show all existing components.
     *
     * @param DateInterval $interval The interval
     *
     * @return string Formatted interval string.
     */
    function format_duration(DateInterval $interval) {
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

    /**
     * Get working duration
     * Loops through associated \Event $periods to get action duration
     */
    public function getWorkingDuration(){
        $periods = $this->getPeriods();

        // Create variables to calculate the working duration
        $reference = new \DateTimeImmutable;
        $endTime = clone $reference;

        foreach($periods as $period){
            $period_duration = $period->getWorkingDuration();
            $period_duration = $this->format_duration_to_hours_1($period_duration);
            $endTime = $endTime->add($period_duration);
        }

        return $reference->diff($endTime);
    }

    /**
     * Get working duration label
     *
     */
    public function getWorkingDurationLabel(){
        $diff  = $this->getWorkingDuration();
        $duration = $this->format_duration_to_hours($diff);

        return $duration->h.'h';
    }

    /**
     * Format an interval to show all existing components.
     *
     * @param DateInterval $interval The interval
     *
     * @return string Formatted interval string.
     */
    function format_duration_to_hours_1(DateInterval $interval) {
        $result = 0;

        // Years
        if ($interval->y) {
            if ($interval->y != 0) {
                $result += $interval->y * 365 * 24;
            }
        }

        // Months
        if ($interval->m) {
            if ($interval->m != 0) {
                $result += $interval->m * 30 * 24;
            }
        }

        // Days
        if ($interval->d) {
            if ($interval->d != 0) {
                $result += $interval->d * 24;
            }
        }

        // Hours
        if ($interval->h) {
            if ($interval->h != 0) {
                $result += $interval->h;
            }
        }

        // Minutes
        if ($interval->i) {
            if ($interval->i != 0) {
                $result += 1;
            }
        }

        if($this->getNbWorkers()!=0){
            $result*=$this->getNbWorkers();
        }
        return new DateInterval('PT'.$result.'H');
    }

    /**
     * Format an interval to show all existing components.
     *
     * @param DateInterval $interval The interval
     *
     * @return string Formatted interval string.
     */
    function format_duration_to_hours(DateInterval $interval) {
        $result = 0;

        // Years
        if ($interval->y) {
            if ($interval->y != 0) {
                $result += $interval->y * 365 * 24;
            }
        }

        // Months
        if ($interval->m) {
            if ($interval->m != 0) {
                $result += $interval->m * 30 * 24;
            }
        }

        // Days
        if ($interval->d) {
            if ($interval->d != 0) {
                $result += $interval->d * 24;
            }
        }

        // Hours
        if ($interval->h) {
            if ($interval->h != 0) {
                $result += $interval->h;
            }
        }

        // Minutes
        if ($interval->i) {
            if ($interval->i != 0) {
                $result += 1;
            }
        }

        return new DateInterval('PT'.$result.'H');
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

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return float
     */
    public function getDensity()
    {
        return $this->density;
    }

    /**
     * @param float $density
     */
    public function setDensity($density)
    {
        $this->density = $density;
    }



    /**
     * @return string
     */
    public function getAim()
    {
        return $this->aim;
    }

    /**
     * @param string $aim
     */
    public function setAim($aim)
    {
        $this->aim = $aim;
    }

    /**
     * @return mixed
     */
    public function getAuxiliary()
    {
        return $this->auxiliary;
    }

    /**
     * @param mixed $auxiliary
     */
    public function setAuxiliary($auxiliary)
    {
        $this->auxiliary = $auxiliary;
    }

    /**
     * @return mixed
     */
    public function getDensityUnit()
    {
        return $this->densityUnit;
    }

    /**
     * @param mixed $densityUnit
     */
    public function setDensityUnit($densityUnit)
    {
        $this->densityUnit = $densityUnit;
    }

    /**
     * @return int
     */
    public function getNbWorkers()
    {
        return $this->nbWorkers;
    }

    /**
     * @param int $nbWorkers
     */
    public function setNbWorkers($nbWorkers)
    {
        $this->nbWorkers = $nbWorkers;
    }

    /**
     * Add expense
     *
     * @param \AppBundle\Entity\Expense $expense
     * @return Action
     */
    public function addExpense(Expense $expense)
    {
        $this->expenses[] = $expense;

        // We also add the current action to the period
        $expense->setAction($this);

        return $this;
    }

    /**
     * Remove expense
     *
     * @param \AppBundle\Entity\Expense $expense
     */
    public function removeExpense(Expense $expense)
    {
        $this->expenses->removeElement($expense);

        // I should do something here to remove the Event $period from the database
    }

    /**
     * Get action
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExpenses()
    {
        return $this->periods;
    }

}

