<?php

namespace EvenementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Res
 *
 * @ORM\Table(name="res")
 * @ORM\Entity(repositoryClass="EvenementBundle\Repository\ResRepository")
 */
class Res
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
     * @var \UserBundle\Entity\Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Column(name="idE", type="integer")
     */
    private $idE;

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
    public function getIdE()
    {
        return $this->idE;
    }

    /**
     * @param int $idE
     */
    public function setIdE($idE)
    {
        $this->idE = $idE;
    }


}

