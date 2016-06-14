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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CropCycle", inversedBy="actions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $cropCycle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Intervention", inversedBy="actions",cascade={"persist"})
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->intervention->getName();
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

