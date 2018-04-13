<?php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity
 */
class Utilisateur extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom", type="string", length=50, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="Telephone", type="string", length=50, nullable=false)
     */
    private $telephone;

    /**
     * @var string
     * @Assert\Image()
     * @Assert\NotBlank(message="Ajouter une image")
     * @ORM\Column(name="photouser", type="string", length=2055)
     */
    private $photouser;

    /**
     * @var string
     *
     * @ORM\Column(name="Sexe", type="string", length=50, nullable=false)
     */
    private $sexe;



    /**
     * @var string
     *
     * @ORM\Column(name="Specialite", type="string", length=50, nullable=true)
     */
    private $specialite;

    /**
     * @var string
     *
     * @ORM\Column(name="Matricule", type="string", length=255, nullable=true)
     */
    private $matricule;



    public function __construct()
    {
        parent::__construct();
        // your own logic
    }



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
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }



    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }


    /**
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @param string $specialite
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
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
    public function getPhotouser()
    {
        return $this->photouser;
    }

    /**
     * @param string $photouser
     */
    public function setPhotouser($photouser)
    {
        $this->photouser = $photouser;
    }

    public function nompernom(){
        return $this->getNom()." ".$this->getPrenom();
    }



}

