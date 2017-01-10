<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FertilizerPrice
 *
 * @ORM\Table(name="fertilizer_price")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FertilizerPriceRepository")
 */
class FertilizerPrice
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fertilizer", inversedBy="prices",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $fertilizer;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\FertilizersPriceUpdate", inversedBy="prices",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $update;

    /**
     * @var float
     *
     * @ORM\Column(name="PN", type="float", nullable=true)
     */
    private $pn;

    /**
     * @var float
     *
     * @ORM\Column(name="PS", type="float", nullable=true)
     */
    private $ps;

    /**
     * @var float
     *
     * @ORM\Column(name="PN500", type="float", nullable=true)
     */
    private $pn500;

    /**
     * @var float
     *
     * @ORM\Column(name="PIL", type="float", nullable=true)
     */
    private $pil;

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
     * @return mixed
     */
    public function getFertilizer()
    {
        return $this->fertilizer;
    }

    /**
     * @param mixed $fertilizer
     */
    public function setFertilizer($fertilizer)
    {
        $this->fertilizer = $fertilizer;

        //Bidirectionnality
        $fertilizer->addPrice($this);
    }

    /**
     * @return mixed
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * @param mixed $update
     */
    public function setUpdate($update)
    {
        $this->update = $update;

    }

    /**
     * @return float
     */
    public function getPn()
    {
        return $this->pn;
    }

    /**
     * @param float $pn
     */
    public function setPn($pn)
    {
        $this->pn = $pn;
    }

    /**
     * @return float
     */
    public function getPs()
    {
        return $this->ps;
    }

    /**
     * @param float $ps
     */
    public function setPs($ps)
    {
        $this->ps = $ps;
    }

    /**
     * @return float
     */
    public function getPn500()
    {
        return $this->pn500;
    }

    /**
     * @param float $pn500
     */
    public function setPn500($pn500)
    {
        $this->pn500 = $pn500;
    }

    /**
     * @return float
     */
    public function getPil()
    {
        return $this->pil;
    }

    /**
     * @param float $pil
     */
    public function setPil($pil)
    {
        $this->pil = $pil;
    }
}

