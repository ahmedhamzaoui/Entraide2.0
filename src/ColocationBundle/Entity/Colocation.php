<?php

namespace ColocationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Colocation
 *
 * @ORM\Table(name="colocation")
 * @ORM\Entity(repositoryClass="ColocationBundle\Repository\ColocationRepository")
 */

class Colocation
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
     * @var \UserBundle\Entity\Utilisateur
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(name="id_user",referencedColumnName="id")
     */
    private $idUser;

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
     * @return int
     */
    public function getNbrrating()
    {
        return $this->nbrrating;
    }

    /**
     * @param int $nbrrating
     */
    public function setNbrrating($nbrrating)
    {
        $this->nbrrating = $nbrrating;
    }

    /**
     * @return int
     */
    public function getNbruser()
    {
        return $this->nbruser;
    }

    /**
     * @param int $nbruser
     */
    public function setNbruser($nbruser)
    {
        $this->nbruser = $nbruser;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrrating", type="integer", nullable=false)
     */
    private $nbrrating;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbruser", type="integer", nullable=false)
     */
    private $nbruser;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbChambre", type="integer", nullable=false)
     */
    private $nbchambre;


    /**
     * @var integer
     *
     * @ORM\Column(name="nbPersonne", type="integer", nullable=false)
     */
    private $nbpersonne;

    /**
     * @return int
     */
    public function getRaiting()
    {
        return $this->raiting;
    }

    /**
     * @param int $raiting
     */
    public function setRaiting($raiting)
    {
        $this->raiting = $raiting;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="raiting", type="integer", nullable=false)
     */
    private $raiting;


    /**
     * @var string
     *
     * @ORM\Column(name="type_log", type="string", length=255, nullable=false)
     */
    private $typeLog;

    /**
     * @var string
     *
     * @ORM\Column(name="valid", type="string", length=255, nullable=true)
     */
    private $valid;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="etage", type="string", length=255, nullable=false)
     */
    private $etage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_dispo", type="date", nullable=false)
     */
    private $dateDispo;

    /**
     * @var string
     *
     * @ORM\Column(name="meuble", type="string", length=255, nullable=false)
     */
    private $meuble;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255, nullable=false)
     */
    private $photo;

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
    public function getNbchambre()
    {
        return $this->nbchambre;
    }

    /**
     * @param int $nbchambre
     */
    public function setNbchambre($nbchambre)
    {
        $this->nbchambre = $nbchambre;
    }

    /**
     * @return int
     */
    public function getNbpersonne()
    {
        return $this->nbpersonne;
    }

    /**
     * @param int $nbpersonne
     */
    public function setNbpersonne($nbpersonne)
    {
        $this->nbpersonne = $nbpersonne;
    }

    /**
     * @return string
     */
    public function getTypeLog()
    {
        return $this->typeLog;
    }

    /**
     * @param string $typeLog
     */
    public function setTypeLog($typeLog)
    {
        $this->typeLog = $typeLog;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
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
     * @return \DateTime
     */
    public function getDateDispo()
    {
        return $this->dateDispo;
    }

    /**
     * @param \DateTime $dateDispo
     */
    public function setDateDispo($dateDispo)
    {
        $this->dateDispo = $dateDispo;
    }

    /**
     * @return string
     */
    public function getMeuble()
    {
        return $this->meuble;
    }

    /**
     * @param string $meuble
     */
    public function setMeuble($meuble)
    {
        $this->meuble = $meuble;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
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
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * @param string $valid
     */
    public function setValid($valid)
    {
        $this->valid = $valid;
    }


}

