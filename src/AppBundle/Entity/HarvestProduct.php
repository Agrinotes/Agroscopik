<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * HarvestProduct
 *
 * @ORM\Table(name="harvest_product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HarvestProductRepository")
 */
class HarvestProduct
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Action", inversedBy="harvestProducts",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

    /**
     * @var float
     *
     * @ORM\Column(name="qty", type="float", nullable=true)
     */
    private $qty;

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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit")
     */
    private $priceUnit;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;


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
     * Set qty
     *
     * @param float $qty
     *
     * @return HarvestProduct
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return float
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return HarvestProduct
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
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

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }


    /**
     * @return mixed
     */
    public function getPriceUnit()
    {
        return $this->priceUnit;
    }

    /**
     * @param mixed $priceUnit
     */
    public function setPriceUnit($priceUnit)
    {
        $this->priceUnit = $priceUnit;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param \AppBundle\Entity\Action $action
     */
    public function setAction(Action $action)
    {
        $this->action = $action;
    }

    /**
     * Get qty
     *
     * @return float
     */
    public function getStdQty()
    {
        $qty = $this->getQty();

        // Get mass conversion factor
        $a = $this->getUnit()->getA();
        $qty *= $a; //To kg

        // Get surface conversion factor if any
        $c = $this->getUnit()->getC();
        if($c){
            $qty *= $c / 10000; // To ha

            $area = $this->getAction()->getCropCycle()->getArea();
            $qty *= $area;
        }


        return $qty;
    }
}
