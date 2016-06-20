<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
            $name = $name.$crop->getName();
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
     * Get startDatetime
     *
     * @return \DateTime
     */
    public function getStartDatetime()
    {
        $actions = $this->getActions();

        $startDatetime = "";

        foreach($actions as $action){
            if($startDatetime == ""){
                $startDatetime = $action->getStartDateTime();
            }
            elseif($startDatetime > $action->getStartDateTime()){
                $startDatetime = $action->getStartDateTime();
            }
        }
        return $startDatetime;
    }

    /**
     * Get endDatetime
     *
     * @return \DateTime
     */
    public function getEndDatetime()
    {
        $actions = $this->getActions();

        $endDatetime = "";

        foreach($actions as $action){
            if($endDatetime == ""){
                $endDatetime = $action->getEndDateTime();
            }
            elseif($endDatetime < $action->getEndDateTime()){
                $endDatetime = $action->getEndDateTime();
            }
        }
        return $endDatetime;
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
}

