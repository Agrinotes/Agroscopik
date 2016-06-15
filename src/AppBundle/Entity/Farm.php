<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Farm
 *
 * @ORM\Table(name="farm")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FarmRepository")
 */
class Farm
{
    public function __construct()
    {
        $this->plots = new ArrayCollection();
        $this->tractors = new ArrayCollection();

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\Plot", mappedBy="farm", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $plots;

    /**
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", inversedBy="farm", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $farmer;

    /**
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\Tractor", mappedBy="farm", cascade={"persist","remove"})
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
     * Set name
     *
     * @param string $name
     *
     * @return Farm
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
     * Add plot
     *
     * @param \AppBundle\Entity\Plot $plot
     * @return Farm
     */
    public function addPlot(\AppBundle\Entity\Plot $plot)
    {
        $this->plots[] = $plot;

        // We also add the current farm to the plot
        $plot->setFarm($this);

        return $this;
    }

    /**
     * Remove plot
     *
     * @param \AppBundle\Entity\Plot $plot
     */
    public function removePlot(\AppBundle\Entity\Plot $plot)
    {
        $this->plots->removeElement($plot);
    }

    /**
     * Get plots
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlots()
    {
        return $this->plots;
    }

    /**
     * Set farmer
     *
     * @param \UserBundle\Entity\User $farmer
     * @return Farm
     */
    public function setFarmer(\UserBundle\Entity\User $farmer)
    {
        $this->farmer = $farmer;

        // With also add this farm to current user
        $farmer->setFarm($this);

        return $this;
    }

    /**
     * Get farmer
     *
     * @return \UserBundle\Entity\User
     */
    public function getFarmer()
    {
        return $this->farmer;
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

        // We also add the current farm to the tractor
        $tractor->setFarm($this);

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
}

