<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FarmFertilizerMvt
 *
 * @ORM\Table(name="farm_fertilizer_mvt")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FarmFertilizerMvtRepository")
 */
class FarmFertilizerMvt
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datetime = new \DateTime();

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FarmFertilizerMvtCategory", inversedBy="movements",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FarmFertilizer", inversedBy="movements",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fertilizer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Action", inversedBy="farmFertilizerMvts",cascade={"persist"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $action;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetimetz")
     */
    private $datetime;

    /**
     * @var float
     *
     * @ORM\Column(name="amount", type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     */
    private $unit;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", nullable=true)
     */
    private $price;


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
     * Set category
     *
     * @param \AppBundle\Entity\FarmFertilizerMvtCategory $category
     * @return FarmFertilizerMvt
     */
    public function setCategory(FarmFertilizerMvtCategory $category)
    {
        $this->category = $category;

        // Bidirectionnality
        $category->addMovement($this);

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\FarmFertilizerMvt
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set fertilizer
     *
     * @param \AppBundle\Entity\FarmFertilizer $fertilizer
     * @return FarmFertilizerMvt
     */
    public function setFertilizer(FarmFertilizer $fertilizer)
    {
        $this->fertilizer = $fertilizer;

        // Bidirectionnality
        $fertilizer->addMovement($this);

        return $this;
    }

    /**
     * Get fertilizer
     *
     * @return \AppBundle\Entity\FarmFertilizerMvt
     */
    public function getFertilizer()
    {
        return $this->fertilizer;
    }

    /**
     * Set action
     *
     * @param \AppBundle\Entity\Action $action
     * @return FarmFertilizerMvt
     */
    public function setAction(Action $action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return \AppBundle\Entity\FarmFertilizerMvt
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set datetime
     *
     * @param \DateTime $datetime
     *
     * @return FarmFertilizerMvt
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set amount
     *
     * @param float $amount
     *
     * @return FarmFertilizerMvt
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
     * Set price
     *
     * @param float $price
     *
     * @return FarmFertilizerMvt
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }
}

