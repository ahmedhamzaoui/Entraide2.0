<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 06/04/2018
 * Time: 00:47
 */

namespace ColocationBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
/**
 *
 *
 * @ORM\Table(name="Reservationcolocation")
 * @ORM\Entity(repositoryClass="ColocationBundle\Repository\ReservationRepository")
 */


class Reservationcolocation
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
     * @var integer
     *
     * @ORM\Column(name="nbplace", type="integer", nullable=false)
     */
    private $nbplace;

    /**
     * @return mixed
     */
    public function getConfirmation()
    {
        return $this->confirmation;
    }

    /**
     * @param mixed $confirmation
     */
    public function setConfirmation($confirmation)
    {
        $this->confirmation = $confirmation;
    }

    /**
     * @return mixed
     */
    public function getExpiredate()
    {
        return $this->expiredate;
    }

    /**
     * @param mixed $expiredate
     */
    public function setExpiredate($expiredate)
    {
        $this->expiredate = $expiredate;
    }
    /**
     * @var $confirmation
     * @ORM\Column(name="confirmation", type="boolean", options={"default":false})
     */
    private $confirmation;
    /**
     * @ORM\Column(name="expiredate", type="datetime", nullable=true)
     *
     */
    private $expiredate;

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
    public function getNbplace()
    {
        return $this->nbplace;
    }

    /**
     * @param int $nbplace
     */
    public function setNbplace($nbplace)
    {
        $this->nbplace = $nbplace;
    }

    /**
     * @return \DateTime
     */
    public function getDateRes()
    {
        return $this->dateRes;
    }

    /**
     * @param \DateTime $dateRes
     */
    public function setDateRes($dateRes)
    {
        $this->dateRes = $dateRes;
    }

    /**
     * @return \ColocationBundle\Entity\Colocation
     */
    public function getIdColocation()
    {
        return $this->idColocation;
    }

    /**
     * @param \ColocationBundle\Entity\Colocation $idColocation
     */
    public function setIdColocation($idColocation)
    {
        $this->idColocation = $idColocation;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_res", type="date", nullable=false)
     */
    private $dateRes;

    /**
     * @var \ColocationBundle\Entity\Colocation
     * @ORM\ManyToOne(targetEntity="ColocationBundle\Entity\Colocation")
     * @ORM\JoinColumn(name="id_colocation",referencedColumnName="id")
     */
    private $idColocation;


}