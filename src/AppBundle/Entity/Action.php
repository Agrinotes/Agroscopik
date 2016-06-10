<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Table(name="action")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActionRepository")
 */
class Action
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CropCycle", inversedBy="actions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cropCycle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Intervention", inversedBy="cropCycleInterventions",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $intervention;

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
     * @return Action
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
     * Set cropCycle
     *
     * @param \AppBundle\Entity\CropCycle $cropCycle
     * @return Action
     */
    public function setCropCycle(CropCycle $cropCycle)
    {
        $this->cropCycle = $cropCycle;

        return $this;
    }

    /**
     * Get cropCycle
     *
     * @return \AppBundle\Entity\CropCycle
     */
    public function getCropCycle()
    {
        return $this->cropCycle;
    }

    /**
     * Set intervention
     *
     * @param \AppBundle\Entity\Intervention $intervention
     * @return Action
     */
    public function setIntervention(Intervention $intervention)
    {
        $this->intervention = $intervention;

        $intervention->addAction($this);

        return $this;
    }

    /**
     * Get intervention
     *
     * @return \AppBundle\Entity\Intervention
     */
    public function getIntervention()
    {
        return $this->intervention;
    }
}

