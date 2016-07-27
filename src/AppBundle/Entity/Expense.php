<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Expense
 *
 * @ORM\Table(name="expense")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ExpenseRepository")
 */
class Expense
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
     * @var int
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Action", inversedBy="expenses",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $action;

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
     * @return Expense
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Expense
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
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
}

