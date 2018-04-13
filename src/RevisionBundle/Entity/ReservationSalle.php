<?php

namespace RevisionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReservationSalle
 *
 * @ORM\Table(name="reservation_salle")
 * @ORM\Entity(repositoryClass="RevisionBundle\Repository\ReservationSalleRepository")
 */
class ReservationSalle
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
     * @ORM\Column(name="user", type="string", length=255)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="salle", type="integer")
     */
    private $salle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTime1", type="datetime")
     */
    private $dateTime1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateTime2", type="datetime")
     */
    private $dateTime2;

    /**
     * @var int
     *
     * @ORM\Column(name="nbPersonnes", type="integer")
     */
    private $nbPersonnes;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="id_connecte", type="integer")
     */
    private $id_connecte;

    /**
     * @return int
     */
    public function getIdConnecte()
    {
        return $this->id_connecte;
    }

    /**
     * @param int $id_connecte
     */
    public function setIdConnecte($id_connecte)
    {
        $this->id_connecte = $id_connecte;
    }

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
     * Set user
     *
     * @param string $user
     *
     * @return ReservationSalle
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set salle
     *
     * @param integer $salle
     *
     * @return ReservationSalle
     */
    public function setSalle($salle)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get salle
     *
     * @return int
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * Set dateTime1
     *
     * @param \DateTime $dateTime1
     *
     * @return ReservationSalle
     */
    public function setDateTime1($dateTime1)
    {
        $this->dateTime1 = $dateTime1;

        return $this;
    }

    /**
     * Get dateTime1
     *
     * @return \DateTime
     */
    public function getDateTime1()
    {
        return $this->dateTime1;
    }

    /**
     * Set dateTime2
     *
     * @param \DateTime $dateTime2
     *
     * @return ReservationSalle
     */
    public function setDateTime2($dateTime2)
    {
        $this->dateTime2 = $dateTime2;

        return $this;
    }

    /**
     * Get dateTime2
     *
     * @return \DateTime
     */
    public function getDateTime2()
    {
        return $this->dateTime2;
    }

    /**
     * Set nbPersonnes
     *
     * @param integer $nbPersonnes
     *
     * @return ReservationSalle
     */
    public function setNbPersonnes($nbPersonnes)
    {
        $this->nbPersonnes = $nbPersonnes;

        return $this;
    }

    /**
     * Set nbPersonnes
     *
     * @param integer $etat
     *
     * @return ReservationSalle
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }
    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * Get nbPersonnes
     *
     * @return int
     */
    public function getNbPersonnes()
    {
        return $this->nbPersonnes;
    }
}

