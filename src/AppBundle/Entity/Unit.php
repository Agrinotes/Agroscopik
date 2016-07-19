<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unit
 *
 * @ORM\Table(name="unit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnitRepository")
 */
class Unit
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UnitCategory", inversedBy="units",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $unitCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var float
     *
     * @ORM\Column(name="A", type="float", nullable=true)
     */
    private $a;

    /**
     * @var float
     *
     * @ORM\Column(name="B", type="float", nullable=true)
     */
    private $b;

    /**
     * @var float
     *
     * @ORM\Column(name="C", type="float", nullable=true)
     */
    private $c;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=255)
     */
    private $symbol;


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
     * @return Unit
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
     * @return Unit
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
     * Set a
     *
     * @param float $a
     *
     * @return Unit
     */
    public function setA($a)
    {
        $this->a = $a;

        return $this;
    }

    /**
     * Get a
     *
     * @return float
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Set b
     *
     * @param float $b
     *
     * @return Unit
     */
    public function setB($b)
    {
        $this->b = $b;

        return $this;
    }

    /**
     * Get b
     *
     * @return float
     */
    public function getB()
    {
        return $this->b;
    }

    /**
     * Set c
     *
     * @param float $c
     *
     * @return Unit
     */
    public function setC($c)
    {
        $this->c = $c;

        return $this;
    }

    /**
     * Get c
     *
     * @return float
     */
    public function getC()
    {
        return $this->c;
    }

    /**
     * Set symbol
     *
     * @param string $symbol
     *
     * @return Unit
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return mixed
     */
    public function getUnitCategory()
    {
        return $this->unitCategory;
    }

    /**
     * @param mixed $unitCategory
     */
    public function setUnitCategory($unitCategory)
    {
        $this->unitCategory = $unitCategory;

        //Bidirectionnality
        $unitCategory->addUnit($this);
    }
}

