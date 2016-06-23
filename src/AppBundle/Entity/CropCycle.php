<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * CropCycle
 *
 * @ORM\Table(name="crop_cycle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CropCycleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CropCycle
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actions = new ArrayCollection();
        $this->crops = new ArrayCollection();
        $this->status = "ActiveAction";
        $this->startDatetime = new \DateTime('now');
        $this->endDatetime = new \DateTime('now');
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Plot", inversedBy="cropCycles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $plot;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Action", mappedBy="cropCycle", cascade={"persist","remove"})
     */
    private $actions;

    /**
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Crop", inversedBy="cropCycles", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $crops;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="latLngs", type="text", nullable=true)
     */
    private $latLngs;

    /**
     * @var string
     *
     * @ORM\Column(name="area", type="decimal", precision=10, scale=2, nullable=true)
     */
    private $area;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDatetime", type="datetime",nullable=true)
     */
    private $startDatetime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDatetime", type="datetime",nullable=true)
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
        $name = "";
        $crops = $this->getCrops();
        foreach ($crops as $crop) {
            $name = $name . " " . $crop->getName();
        }
        return $name;
    }

    /**
     * Set plot
     *
     * @param \AppBundle\Entity\Plot $plot
     * @return CropCycle
     */
    public function setPlot(Plot $plot)
    {
        $this->plot = $plot;

        return $this;
    }

    /**
     * Get plot
     *
     * @return \AppBundle\Entity\Plot
     */
    public function getPlot()
    {
        return $this->plot;
    }

    /**
     * Add action
     *
     * @param \AppBundle\Entity\Action $action
     * @return CropCycle
     */
    public function addAction(Action $action)
    {
        $this->actions[] = $action;

        // We also add the current cropCycle to the action
        $action->setCropCycle($this);

        return $this;
    }

    /**
     * Remove action
     *
     * @param \AppBundle\Entity\Action $action
     */
    public function removeAction(Action $action)
    {
        $this->actions->removeElement($action);

        // I should do something here
    }

    /**
     * Get action
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * Add crop
     *
     * @param \AppBundle\Entity\Crop $crop
     * @return CropCycle
     */
    public function addCrop(Crop $crop)
    {
        $this->crops[] = $crop;

        $crop->addCropCycle($this); // Bidirectionnality

        return $this;
    }

    /**
     * Remove crops
     *
     * @param \AppBundle\Entity\Crop $crop
     */
    public function removeCrop(Crop $crop)
    {
        $this->crops->removeElement($crop);

        $crop->removeCropCycle($this); // This must be verified
    }

    /**
     * Get crops
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCrops()
    {
        return $this->crops;
    }


    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Set latLngs
     *
     * @param string $latLngs
     * @return Plot
     */
    public function setLatLngs($latLngs)
    {
        $this->latLngs = $latLngs;

        return $this;
    }

    /**
     * Get latLngs
     *
     * @return string
     */
    public function getLatLngs()
    {
        return $this->latLngs;
    }

    /**
     * Set area
     *
     * @param string $area
     * @return Plot
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string
     */
    public function getArea()
    {
        return $this->area;
    }


    /**
     * @param \DateTime $startDatetime
     * @return CropCycle
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
     * @param \DateTime $endDatetime
     * @return CropCycle
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
        $actions = $this->getActions();
        $i = 0;
        foreach($actions as $action){
            if($i == 0){
                $earliest = $action->getStartDatetime();
                $i++;
            }else{
                if($action->getStartDatetime()< $earliest){
                    $earliest = $action->getStartDatetime();
                }
            }
        }
        $this->setStartDatetime($earliest);
    }

    public function updateEndDatetime(){
        $actions = $this->getActions();
        $i = 0;
        foreach($actions as $action){
            if($i == 0){
                $oldest = $action->getEndDatetime();
                $i++;
            }else{
                if($action->getEndDatetime()> $oldest){
                    $oldest = $action->getEndDatetime();
                }
            }
        }
        $this->setEndDatetime($oldest);
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

