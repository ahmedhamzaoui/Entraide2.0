<?php

namespace ReclamationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity(repositoryClass="ReclamationBundle\Repository\ReclamationRepository")
 */
class Reclamation
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
     * @ORM\Column(name="description", type="string", length=1200, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_decouverte", type="date", nullable=true)
     */
    private $dateDecouverte;

    /**
     * @return \DateTime
     */
    public function getExpiredate()
    {
        return $this->expiredate;
    }

    /**
     * @param \DateTime $expiredate
     */
    public function setExpiredate($expiredate)
    {
        $this->expiredate = $expiredate;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiredate", type="datetime", nullable=true)
     */
    private $expiredate;
    /**
     * @var string
     *
     * @ORM\Column(name="lieu_decouverte", type="string", length=50, nullable=true)
     */
    private $lieuDecouverte;

    /**
     * @var string
     *
     * @ORM\Column(name="typeobj_perdu", type="string", length=20, nullable=true)
     */
    private $typeobjPerdu;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="autretypeobj_perdu", type="string", length=30, nullable=true)
     */
    private $autretypeobjPerdu;

    /**
     * @var string
     *
     * @ORM\Column(name="localisation", type="string", length=30, nullable=true)
     */
    private $localisation;

    /**
     * @var string
     *
     * @ORM\Column(name="autrelocalisation", type="string", length=30, nullable=true)
     */
    private $autrelocalisation;

    /**
     * @var string
     *
     * @ORM\Column(name="etage", type="string", length=30, nullable=true)
     */
    private $etage;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=30, nullable=true)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="salle", type="string", length=30, nullable=true)
     */
    private $salle;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(name="photo2", type="string", length=50, nullable=true)
     */
    private $photo2;

    /**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")

     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="validation", type="string", length=255, nullable=true)
     */
    private $validation;
    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=true)
     */
    private $etat;

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
     * @return \DateTime
     */
    public function getDateDecouverte()
    {
        return $this->dateDecouverte;
    }

    /**
     * @param \DateTime $dateDecouverte
     */
    public function setDateDecouverte($dateDecouverte)
    {
        $this->dateDecouverte = $dateDecouverte;
    }

    /**
     * @return string
     */
    public function getLieuDecouverte()
    {
        return $this->lieuDecouverte;
    }

    /**
     * @param string $lieuDecouverte
     */
    public function setLieuDecouverte($lieuDecouverte)
    {
        $this->lieuDecouverte = $lieuDecouverte;
    }

    /**
     * @return string
     */
    public function getTypeobjPerdu()
    {
        return $this->typeobjPerdu;
    }

    /**
     * @param string $typeobjPerdu
     */
    public function setTypeobjPerdu($typeobjPerdu)
    {
        $this->typeobjPerdu = $typeobjPerdu;
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
     * @return string
     */
    public function getAutretypeobjPerdu()
    {
        return $this->autretypeobjPerdu;
    }

    /**
     * @param string $autretypeobjPerdu
     */
    public function setAutretypeobjPerdu($autretypeobjPerdu)
    {
        $this->autretypeobjPerdu = $autretypeobjPerdu;
    }

    /**
     * @return string
     */
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * @param string $localisation
     */
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;
    }

    /**
     * @return string
     */
    public function getAutrelocalisation()
    {
        return $this->autrelocalisation;
    }

    /**
     * @param string $autrelocalisation
     */
    public function setAutrelocalisation($autrelocalisation)
    {
        $this->autrelocalisation = $autrelocalisation;
    }

    /**
     * @return string
     */
    public function getEtage()
    {
        return $this->etage;
    }

    /**
     * @param string $etage
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;
    }

    /**
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * @param string $matricule
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;
    }

    /**
     * @return string
     */
    public function getSalle()
    {
        return $this->salle;
    }

    /**
     * @param string $salle
     */
    public function setSalle($salle)
    {
        $this->salle = $salle;
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
    public function getPhoto2()
    {
        return $this->photo2;
    }

    /**
     * @param string $photo2
     */
    public function setPhoto2($photo2)
    {
        $this->photo2 = $photo2;
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
     * @return string
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param string $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }


}

