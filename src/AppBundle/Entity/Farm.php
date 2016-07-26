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
        $this->implements = new ArrayCollection();
        $this->farmSpecialities = new ArrayCollection();
        $this->farmFertilizers = new ArrayCollection();

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
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\Implement", mappedBy="farm", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $implements;

    /**
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\FarmSpeciality", mappedBy="farm", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $farmSpecialities;

    /**
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\FarmFertilizer", mappedBy="farm", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $farmFertilizers;

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

    /**
     * Add implement
     *
     * @param \AppBundle\Entity\Implement $implement
     * @return Farm
     */
    public function addImplement(Implement $implement)
    {
        $this->implements[] = $implement;

        // We also add the current farm to the tractor
        $implement->setFarm($this);

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
     * Add farm speciality
     *
     * @param \AppBundle\Entity\FarmSpeciality $speciality
     * @return Farm
     */
    public function addFarmSpeciality(FarmSpeciality $speciality)
    {
        $this->farmSpecialities[] = $speciality;

        // We also add the current farm to the tractor
        $speciality->setFarm($this);

        return $this;
    }

    /**
     * Remove farm speciality
     *
     * @param \AppBundle\Entity\FarmSpeciality $speciality
     */
    public function removeFarmSpeciality(FarmSpeciality $speciality)
    {
        $this->farmSpecialities->removeElement($speciality);
    }

    /**
     * Get farm Specialities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFarmSpecialities()
    {
        return $this->farmSpecialities;
    }

    /**
     * Add farm fertilizer
     *
     * @param \AppBundle\Entity\FarmFertilizer $fertilizer
     * @return Farm
     */
    public function addFarmFertilizer(FarmFertilizer $fertilizer)
    {
        $this->farmFertilizers[] = $fertilizer;

        // We also add the current farm to the tractor
        $fertilizer->setFarm($this);

        return $this;
    }

    /**
     * Remove farm fertilizer
     *
     * @param \AppBundle\Entity\FarmFertilizer $fertilizer
     */
    public function removeFarmFertilizer(FarmFertilizer $fertilizer)
    {
        $this->farmFertilizers->removeElement($fertilizer);
    }

    /**
     * Get farm fertilizers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFarmFertilizers()
    {
        return $this->farmFertilizers;
    }

    /**
     * Get total area
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArea()
    {
        $plots = $this->getPlots();
        $area = 0;
        foreach($plots as $plot){
            $plotArea = $plot->getArea();
            $area+=$plotArea;
        }
        return $area;
    }

}

