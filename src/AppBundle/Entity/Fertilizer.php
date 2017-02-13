<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fertilizer
 *
 * @ORM\Table(name="fertilizer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FertilizerRepository")
 */
class Fertilizer
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->farmFertilizers = new ArrayCollection();
        $this->prices = new ArrayCollection();

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
     * @ORM\OneToMany (targetEntity="AppBundle\Entity\FarmFertilizer", mappedBy="fertilizer", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $farmFertilizers;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="alternative_name", type="string", length=255, nullable=true, unique=false)
     */
    private $alternativeName;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="formula", type="string", length=255, nullable=true)
     */
    private $formula;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FertilizerPrice", mappedBy="fertilizer", cascade={"persist","remove"})
     */
    private $prices;

    /**
     * @var float
     *
     * @ORM\Column(name="N", type="float", nullable=true)
     */
    private $n;

    /**
     * @var float
     *
     * @ORM\Column(name="P2O5", type="float", nullable=true)
     */
    private $p2O5;

    /**
     * @var float
     *
     * @ORM\Column(name="K2O", type="float", nullable=true)
     */
    private $k2O;

    /**
     * @var float
     *
     * @ORM\Column(name="CaO", type="float", nullable=true)
     */
    private $caO;

    /**
     * @var float
     *
     * @ORM\Column(name="MgO", type="float", nullable=true)
     */
    private $mgO;

    /**
     * @var float
     *
     * @ORM\Column(name="Fe", type="float", nullable=true)
     */
    private $fe;

    /**
     * @var float
     *
     * @ORM\Column(name="SO3", type="float", nullable=true)
     */
    private $sO3;

    /**
     * @var float
     *
     * @ORM\Column(name="Zn", type="float", nullable=true)
     */
    private $zn;

    /**
     * @var float
     *
     * @ORM\Column(name="B", type="float", nullable=true)
     */
    private $b;

    /**
     * @var float
     *
     * @ORM\Column(name="Mn", type="float", nullable=true)
     */
    private $mn;

    /**
     * @var float
     *
     * @ORM\Column(name="Cu", type="float", nullable=true)
     */
    private $cu;

    /**
     * @var float
     *
     * @ORM\Column(name="ISMO", type="float", nullable=true)
     */
    private $ismo;

    /**
     * @var float
     *
     * @ORM\Column(name="CN", type="float", nullable=true)
     */
    private $cn;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="ft", type="text", nullable=true)
     */
    private $ft;

    /**
     * @var string
     *
     * @ORM\Column(name="fds", type="text", nullable=true)
     */
    private $fds;

    /**
     *
     * @ORM\Column(name="organic", type="boolean", nullable=true)
     */
    private $organic;


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
     * @return Fertilizer
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
     * Set formula
     *
     * @param string $formula
     *
     * @return Fertilizer
     */
    public function setFormula($formula)
    {
        $this->formula = $formula;

        return $this;
    }

    /**
     * Get formula
     *
     * @return string
     */
    public function getFormula()
    {
        return $this->formula;
    }

    /**
     * Set n
     *
     * @param float $n
     *
     * @return Fertilizer
     */
    public function setN($n)
    {
        $this->n = $n;

        return $this;
    }

    /**
     * Get n
     *
     * @return float
     */
    public function getN()
    {
        return $this->n;
    }

    /**
     * Set p2O5
     *
     * @param float $p2O5
     *
     * @return Fertilizer
     */
    public function setP2O5($p2O5)
    {
        $this->p2O5 = $p2O5;

        return $this;
    }

    /**
     * Get p2O5
     *
     * @return float
     */
    public function getP2O5()
    {
        return $this->p2O5;
    }

    /**
     * Set k2O
     *
     * @param float $k2O
     *
     * @return Fertilizer
     */
    public function setK2O($k2O)
    {
        $this->k2O = $k2O;

        return $this;
    }

    /**
     * Get k2O
     *
     * @return float
     */
    public function getK2O()
    {
        return $this->k2O;
    }

    /**
     * Set caO
     *
     * @param float $caO
     *
     * @return Fertilizer
     */
    public function setCaO($caO)
    {
        $this->caO = $caO;

        return $this;
    }

    /**
     * Get caO
     *
     * @return float
     */
    public function getCaO()
    {
        return $this->caO;
    }

    /**
     * Set mgO
     *
     * @param float $mgO
     *
     * @return Fertilizer
     */
    public function setMgO($mgO)
    {
        $this->mgO = $mgO;

        return $this;
    }

    /**
     * Get mgO
     *
     * @return float
     */
    public function getMgO()
    {
        return $this->mgO;
    }

    /**
     * Set fe
     *
     * @param float $fe
     *
     * @return Fertilizer
     */
    public function setFe($fe)
    {
        $this->fe = $fe;

        return $this;
    }

    /**
     * Get fe
     *
     * @return float
     */
    public function getFe()
    {
        return $this->fe;
    }

    /**
     * Set sO3
     *
     * @param float $sO3
     *
     * @return Fertilizer
     */
    public function setSO3($sO3)
    {
        $this->sO3 = $sO3;

        return $this;
    }

    /**
     * Get sO3
     *
     * @return float
     */
    public function getSO3()
    {
        return $this->sO3;
    }

    /**
     * Set zn
     *
     * @param float $zn
     *
     * @return Fertilizer
     */
    public function setZn($zn)
    {
        $this->zn = $zn;

        return $this;
    }

    /**
     * Get zn
     *
     * @return float
     */
    public function getZn()
    {
        return $this->zn;
    }

    /**
     * Set b
     *
     * @param float $b
     *
     * @return Fertilizer
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
     * Set mn
     *
     * @param float $mn
     *
     * @return Fertilizer
     */
    public function setMn($mn)
    {
        $this->mn = $mn;

        return $this;
    }

    /**
     * Get mn
     *
     * @return float
     */
    public function getMn()
    {
        return $this->mn;
    }

    /**
     * Set cu
     *
     * @param float $cu
     *
     * @return Fertilizer
     */
    public function setCu($cu)
    {
        $this->cu = $cu;

        return $this;
    }

    /**
     * Get cu
     *
     * @return float
     */
    public function getCu()
    {
        return $this->cu;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Fertilizer
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * Add farm fertilizer
     *
     * @param \AppBundle\Entity\FarmFertilizer $fertilizer
     * @return Fertilizer
     */
    public function addFarmFertilizer(FarmFertilizer $fertilizer)
    {
        $this->farmFertilizers[] = $fertilizer;

        // We also add the current speciality to the farmSpeciality
        $fertilizer->setFertilizer($this);

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
     * Add price
     *
     * @param \AppBundle\Entity\FertilizerPrice $price
     * @return Fertilizer
     */
    public function addPrice(FertilizerPrice $price)
    {
        $this->prices[] = $price;

        return $this;
    }

    /**
     * Remove price
     *
     * @param \AppBundle\Entity\FertilizerPrice $price
     */
    public function removePrice(FertilizerPrice $price)
    {
        $this->prices->removeElement($price);

        $price->setFertilizer(""); // That's a problem because its Category cannot be null... Should be resolved soon
    }

    /**
     * @return mixed
     */
    public function getPrices()
    {
        return $this->prices;
    }

    /**
     * @return string
     */
    public function getFt()
    {
        return $this->ft;
    }

    /**
     * @param string $ft
     */
    public function setFt($ft)
    {
        $this->ft = $ft;
    }

    /**
     * @return string
     */
    public function getFds()
    {
        return $this->fds;
    }

    /**
     * @param string $fds
     */
    public function setFds($fds)
    {
        $this->fds = $fds;
    }

    /**
     * @return mixed
     */
    public function getOrganic()
    {
        return $this->organic;
    }

    /**
     * @param mixed $organic
     */
    public function setOrganic($organic)
    {
        $this->organic = $organic;
    }

    /**
     * @return float
     */
    public function getIsmo()
    {
        return $this->ismo;
    }

    /**
     * @param float $ismo
     */
    public function setIsmo($ismo)
    {
        $this->ismo = $ismo;
    }

    /**
     * @return float
     */
    public function getCn()
    {
        return $this->cn;
    }

    /**
     * @param float $cn
     */
    public function setCn($cn)
    {
        $this->cn = $cn;
    }

    /**
     * @return string
     */
    public function getAlternativeName()
    {
        return $this->alternativeName;
    }

    /**
     * @param string $alternativeName
     */
    public function setAlternativeName($alternativeName)
    {
        $this->alternativeName = $alternativeName;
    }
}

