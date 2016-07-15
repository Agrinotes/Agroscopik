<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Intervention
 *
 * @ORM\Table(name="intervention")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InterventionRepository")
 */
class Intervention
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->actions = new ArrayCollection();
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\InterventionCategory", inversedBy="interventions",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $interventionCategory;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Action", mappedBy="intervention", cascade={"persist","remove"})
     */
    private $actions;

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
     * @return Intervention
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
     * Set interventionCategory
     *
     * @param \AppBundle\Entity\InterventionCategory $interventionCategory
     * @return Intervention
     */
    public function setInterventionCategory(InterventionCategory $interventionCategory)
    {
        $this->interventionCategory = $interventionCategory;


        return $this;
    }

    /**
     * Get interventionCategory
     *
     * @return \AppBundle\Entity\InterventionCategory
     */
    public function getInterventionCategory()
    {
        return $this->interventionCategory;
    }

    /**
     * Add action
     *
     * @param \AppBundle\Entity\Action $action
     * @return Intervention
     */
    public function addAction(Action $action)
    {
        $this->actions[] = $action;

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
    }

    /**
     * Get actions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActions()
    {
        return $this->actions;
    }

}

