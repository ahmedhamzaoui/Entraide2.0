<?php

namespace RevisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salle
 *
 * @ORM\Table(name="salle")
 * @ORM\Entity(repositoryClass="RevisionBundle\Repository\SalleRepository")
 */
class Salle
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
     * @var int
     *
     * @ORM\Column(name="numsalle", type="integer")
     */
    private $numsalle;

    /**
     * @var int
     *
     * @ORM\Column(name="numbloc", type="integer")
     */
    private $numbloc;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrchaise", type="integer")
     */
    private $nbrchaise;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrtable", type="integer")
     */
    private $nbrtable;


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
     * Set numsalle
     *
     * @param integer $numsalle
     *
     * @return Salle
     */
    public function setNumsalle($numsalle)
    {
        $this->numsalle = $numsalle;

        return $this;
    }

    /**
     * Get numsalle
     *
     * @return int
     */
    public function getNumsalle()
    {
        return $this->numsalle;
    }

    /**
     * Set numbloc
     *
     * @param integer $numbloc
     *
     * @return Salle
     */
    public function setNumbloc($numbloc)
    {
        $this->numbloc = $numbloc;

        return $this;
    }

    /**
     * Get numbloc
     *
     * @return int
     */
    public function getNumbloc()
    {
        return $this->numbloc;
    }

    /**
     * Set nbrchaise
     *
     * @param integer $nbrchaise
     *
     * @return Salle
     */
    public function setNbrchaise($nbrchaise)
    {
        $this->nbrchaise = $nbrchaise;

        return $this;
    }

    /**
     * Get nbrchaise
     *
     * @return int
     */
    public function getNbrchaise()
    {
        return $this->nbrchaise;
    }

    /**
     * Set nbrtable
     *
     * @param integer $nbrtable
     *
     * @return Salle
     */
    public function setNbrtable($nbrtable)
    {
        $this->nbrtable = $nbrtable;

        return $this;
    }

    /**
     * Get nbrtable
     *
     * @return int
     */
    public function getNbrtable()
    {
        return $this->nbrtable;
    }
}

