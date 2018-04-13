<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PartClub
 *
 * @ORM\Table(name="part_club")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\PartClubRepository")
 */
class PartClub
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
     * @ORM\Column(name="idMembre", type="integer")
     */
    private $idMembre;

    /**
     * @var int
     *
     * @ORM\Column(name="idClub", type="integer")
     */
    private $idClub;


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
     * Set idMembre
     *
     * @param integer $idMembre
     *
     * @return PartClub
     */
    public function setIdMembre($idMembre)
    {
        $this->idMembre = $idMembre;

        return $this;
    }

    /**
     * Get idMembre
     *
     * @return int
     */
    public function getIdMembre()
    {
        return $this->idMembre;
    }

    /**
     * Set idClub
     *
     * @param integer $idClub
     *
     * @return PartClub
     */
    public function setIdClub($idClub)
    {
        $this->idClub = $idClub;

        return $this;
    }

    /**
     * Get idClub
     *
     * @return int
     */
    public function getIdClub()
    {
        return $this->idClub;
    }
}

