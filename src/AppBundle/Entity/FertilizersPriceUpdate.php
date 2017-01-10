<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FertilizersPriceUpdate
 *
 * @ORM\Table(name="fertilizers_price_update")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FertilizersPriceUpdateRepository")
 */
class FertilizersPriceUpdate
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
        $this->prices = new ArrayCollection();
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", unique=true)
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FertilizerPrice", mappedBy="update", cascade={"persist","remove"})
     */
    private $prices;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FertilizersPriceUpdate
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Add price
     *
     * @param \AppBundle\Entity\FertilizerPrice $price
     * @return FertilizersPriceUpdate
     */
    public function addPrice(FertilizerPrice $price)
    {
        $this->prices[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \AppBundle\Entity\FertilizerPrice $price
     */
    public function removePrice(FertilizerPrice $price)
    {
        $this->prices->removeElement($price);

        $price->setFertilizer(""); // That's a problem because its Category cannot be null... Should be resolved soon
    }

    /**
     * @return mixed
     */
    public function getPrices()
    {
        return $this->prices;
    }
}

