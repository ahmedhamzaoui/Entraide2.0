<?php
namespace GestionCovoiturageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mgilet\NotificationBundle\Annotation\Notifiable;
use Mgilet\NotificationBundle\NotifiableInterface;

/**
 * Covoiturage
 *
 * @ORM\Table(name="covoiturage", indexes={@ORM\Index(name="fk_user", columns={"ID_USER"})})
 * @ORM\Entity(repositoryClass="GestionCovoiturageBundle\Repository\CovoiturageRepository")
 * @Notifiable(name="covoiturage")
**/

class Covoiturage implements NotifiableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;



    /**
     * @var string
     *
     * @ORM\Column(name="depart", type="string", length=50, nullable=false)
     */
    private $depart;
    /**
     * @var string
     *
     * @ORM\Column(name="arrive", type="string", length=50, nullable=false)
     */
    private $arrive;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */
    private $date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sys", type="date", nullable=false)
     */
    private $dateSys;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="heure", type="time", nullable=false)
     */
    private $heure;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrPlaces", type="integer", nullable=true)
     */
    private $nbrplaces;

    /**
     * @var string
     *
     * @ORM\Column(name="comfort", type="string", length=50, nullable=false)
     */
    private $comfort;

    /**
     * @var string
     *
     * @ORM\Column(name="fumeur", type="string", length=50, nullable=false)
     */
    private $fumeur;

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
    public function getDepart()
    {
        return $this->depart;
    }

    /**
     * @param string $depart
     */
    public function setDepart($depart)
    {
        $this->depart = $depart;
    }

    /**
     * @return string
     */
    public function getDepart1()
    {
        return $this->depart1;
    }

    /**
     * @param string $depart1
     */
    public function setDepart1($depart1)
    {
        $this->depart1 = $depart1;
    }

    /**
     * @return string
     */
    public function getArrive()
    {
        return $this->arrive;
    }

    /**
     * @param string $arrive
     */
    public function setArrive($arrive)
    {
        $this->arrive = $arrive;
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
     * @return \DateTime
     */
    public function getDateSys()
    {
        return $this->dateSys;
    }

    /**
     * @param \DateTime $dateSys
     */
    public function setDateSys($dateSys)
    {
        $this->dateSys = $dateSys;
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
     * @return int
     */
    public function getNbrplaces()
    {
        return $this->nbrplaces;
    }

    /**
     * @param int $nbrplaces
     */
    public function setNbrplaces($nbrplaces)
    {
        $this->nbrplaces = $nbrplaces;
    }

    /**
     * @return string
     */
    public function getComfort()
    {
        return $this->comfort;
    }

    /**
     * @param string $comfort
     */
    public function setComfort($comfort)
    {
        $this->comfort = $comfort;
    }

    /**
     * @return string
     */
    public function getFumeur()
    {
        return $this->fumeur;
    }

    /**
     * @param string $fumeur
     */
    public function setFumeur($fumeur)
    {
        $this->fumeur = $fumeur;
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

