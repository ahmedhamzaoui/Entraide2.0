<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club
 *
 * @ORM\Table(name="club", indexes={@ORM\Index(name="fk_id", columns={"idClub"})})
 * @ORM\Entity
 */
class Club
{
    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=55, nullable=false)
     */
    private $nom;

    /**
     * @var String
     *
     * @ORM\Column(name="Role", type="string", nullable=false)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=55, nullable=false)
     */
    private $photo;

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="idClub", type="integer")
     */
    private $idclub;

    /**
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     *
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     *
     */
    private $idUser;

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
     * @return String
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param String $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
     * @return int
     */
    public function getIdclub()
    {
        return $this->idclub;
    }

    /**
     * @param int $idclub
     */
    public function setIdclub($idclub)
    {
        $this->idclub = $idclub;
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



}

