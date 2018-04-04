<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservationcovoiturage
 *
 * @ORM\Table(name="reservationcovoiturage", indexes={@ORM\Index(name="fk_annonce", columns={"ID_ANNONCE"}), @ORM\Index(name="fk_chauffeur", columns={"ID_CHAUFFEUR"}), @ORM\Index(name="fk_reserve", columns={"ID_RESERVE"})})
 * @ORM\Entity
 */
class Reservationcovoiturage
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
     * @var \UserBundle\Entity\Covoiturage
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Covoiturage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ANNONCE", referencedColumnName="id")
     * })
     */
    private $idAnnonce;

    /**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_CHAUFFEUR", referencedColumnName="id")
     * })
     */
    private $idChauffeur;

    /**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_RESERVE", referencedColumnName="id")
     * })
     */
    private $idReserve;


}

