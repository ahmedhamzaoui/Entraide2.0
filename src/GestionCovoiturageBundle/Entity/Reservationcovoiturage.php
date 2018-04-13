<?php

namespace GestionCovoiturageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * Reservationcovoiturage
 *
 * @ORM\Table(name="reservationcovoiturage", indexes={@ORM\Index(name="fk_annonce", columns={"IdAnnonce"}), @ORM\Index(name="fk_chauffeur", columns={"idChauffeur"}), @ORM\Index(name="fk_reserve", columns={"IdReserve"})})
 * @ORM\Entity(repositoryClass="GestionCovoiturageBundle\Repository\ReservationcovoiturageRepository")
 * @Notifiable(name="utilisateur")
 */
class Reservationcovoiturage implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="ETAT", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var integer
     *
     * @ORM\Column(name="NBPLACES", type="integer", nullable=false)
     */
    private $nbplaces;

    /**
     * @var \GestionCovoiturageBundle\Entity\Covoiturage
     *
     * @ORM\ManyToOne(targetEntity="GestionCovoiturageBundle\Entity\Covoiturage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdAnnonce", referencedColumnName="id")
     * })
     */
    private $IdAnnonce;

    /**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdChauffeur", referencedColumnName="id")
     * })
     */
    private $IdChauffeur;

    /**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="IdReserve", referencedColumnName="id")
     * })
     */
    private $IdReserve;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param int $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return int
     */
    public function getNbplaces()
    {
        return $this->nbplaces;
    }

    /**
     * @param int $nbplaces
     */
    public function setNbplaces($nbplaces)
    {
        $this->nbplaces = $nbplaces;
    }

    /**
     * @return Covoiturage
     */
    public function getIdAnnonce()
    {
        return $this->IdAnnonce;
    }

    /**
     * @param Covoiturage $IdAnnonce
     */
    public function setIdAnnonce($IdAnnonce)
    {
        $this->IdAnnonce = $IdAnnonce;
    }

    /**
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getIdChauffeur()
    {
        return $this->IdChauffeur;
    }

    /**
     * @param \UserBundle\Entity\Utilisateur $IdChauffeur
     */
    public function setIdChauffeur($IdChauffeur)
    {
        $this->IdChauffeur = $IdChauffeur;
    }

    /**
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getIdReserve()
    {
        return $this->IdReserve;
    }

    /**
     * @param \UserBundle\Entity\Utilisateur $IdReserve
     */
    public function setIdReserve($IdReserve)
    {
        $this->IdReserve = $IdReserve;
    }



}

