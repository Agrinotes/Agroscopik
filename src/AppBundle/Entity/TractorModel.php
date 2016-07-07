<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tractor Model
 *
 * @ORM\Table(name="tractor_model")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TractorModelRepository")
 */
class TractorModel
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
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="power", type="integer", nullable=true)
     */
    private $power;

    /**
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\Tractor", mappedBy="model", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tractors;


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
     * Set brand
     *
     * @param string $brand
     *
     * @return TractorBrand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return TractorBrand
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set power
     *
     * @param integer $power
     *
     * @return TractorBrand
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return int
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Add tractor
     *
     * @param \AppBundle\Entity\Tractor $tractor
     * @return Farm
     */
    public function addTractor(Tractor $tractor)
    {
        $this->tractors[] = $tractor;

        return $this;
    }

    /**
     * Remove tractor
     *
     * @param \AppBundle\Entity\Tractor $tractor
     */
    public function removeTractor(\AppBundle\Entity\Tractor $tractor)
    {
        $this->tractors->removeElement($tractor);
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

    public function getLabel(){

        $label = $this->brand." - ".$this->name;

        return $label;
    }
}

