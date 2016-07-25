<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * FarmFertilizerMvtCategory
 *
 * @ORM\Table(name="farm_fertilizer_mvt_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FarmFertilizerMvtCategoryRepository")
 */
class FarmFertilizerMvtCategory
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->movements = new ArrayCollection();
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FarmFertilizerMvt", mappedBy="category", cascade={"persist","remove"})
     */
    private $movements;

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
     * @return FarmFertilizerMvtCategory
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
     * Set slug
     *
     * @param string $slug
     *
     * @return FarmFertilizerMvtCategory
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add movement
     *
     * @param \AppBundle\Entity\FarmFertilizerMvt $movement
     * @return FarmFertilizerMvtCategory
     */
    public function addMovement(FarmFertilizerMvt $movement)
    {
        $this->movements[] = $movement;

        return $this;
    }

    /**
     * Remove movement
     *
     * @param \AppBundle\Entity\FarmFertilizerMvt $movement
     */
    public function removeMovement(FarmFertilizerMvt $movement)
    {
        $this->movements->removeElement($movement);

        $movement->setCategory(""); // That's a problem because its Category cannot be null... Should be resolved soon
    }

    /**
     * Get movements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMovements()
    {
        return $this->movements;
    }
}

