<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * InterventionCategory
 *
 * @ORM\Table(name="intervention_category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InterventionCategoryRepository")
 */
class InterventionCategory
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->interventions = new ArrayCollection();
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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Intervention", mappedBy="actions", cascade={"persist","remove"})
     */
    private $interventions;

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
     * @return InterventionCategory
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
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }



    /**
     * Add intervention
     *
     * @param \AppBundle\Entity\Intervention $intervention
     * @return InterventionCategory
     */
    public function addIntervention(Intervention $intervention)
    {
        $this->interventions[] = $intervention;

        return $this;
    }

    /**
     * Remove intervention
     *
     * @param \AppBundle\Entity\Intervention $intervention
     */
    public function removeIntervention(Intervention $intervention)
    {
        $this->interventions->removeElement($intervention);

        $intervention->setInterventionCategory(""); // That's a problem because Intervention Category cannot be null
    }

    /**
     * Get interventions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInterventions()
    {
        return $this->interventions;
    }
}

