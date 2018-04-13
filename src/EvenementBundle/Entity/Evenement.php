<?php

namespace EvenementBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="fk_evenement", columns={"ID_USER"})})
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\EvenementRepository")
 */
class Evenement
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="date", nullable=false)
     */
    private $heure;


    /**
     * @var string
     *
     * @ORM\Column(name="lieu", type="string", length=255, nullable=false)
     */
    private $lieu;

    /**
     * @var string
     * @Assert\Image()
     * @Assert\NotBlank(message="Ajouter une image")
     * @ORM\Column(name="photo", type="string", length=20000, nullable=false)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=55, nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbre_dispo", type="integer", nullable=false)
     */
    private $nbreDispo;

    /**
     * @var string
     *
     * @ORM\Column(name="organisateur", type="string", length=55, nullable=true)
     */
    private $organisateur;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="payant", type="boolean", nullable=false)
     */
    private $payant;

    /**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="id")
     * })
     */
    private $idUser;

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
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param string $lieu
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
     * @return int
     */
    public function getNbreDispo()
    {
        return $this->nbreDispo;
    }

    /**
     * @param int $nbreDispo
     */
    public function setNbreDispo($nbreDispo)
    {
        $this->nbreDispo = $nbreDispo;
    }

    /**
     * @return string
     */
    public function getOrganisateur()
    {
        return $this->organisateur;
    }

    /**
     * @param string $organisateur
     */
    public function setOrganisateur($organisateur)
    {
        $this->organisateur = $organisateur;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return \UserBundle\Entity\Utilisateur
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \UserBundle\Entity\Utilisateur $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \DateTime
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param \DateTime $heure
     */
    public function setHeure($heure)
    {
        $this->heure = $heure;
    }

    /**
     * @return bool
     */
    public function isPayant()
    {
        return $this->payant;
    }

    /**
     * @param bool $payant
     */
    public function setPayant($payant)
    {
        $this->payant = $payant;
    }

    public function __toString()
    {
       return $this->getNom();
    }


}

