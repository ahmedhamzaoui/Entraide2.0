<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cours
 *
 * @ORM\Table(name="cours", indexes={@ORM\Index(name="fq_prof_cours", columns={"id_prof"})})
 * @ORM\Entity
 */
class Cours
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
     * @ORM\Column(name="id_prof", type="integer", nullable=false)
     */
    private $idProf;

    /**
     * @var string
     *
     * @ORM\Column(name="module", type="string", length=100, nullable=false)
     */
    private $module;

    /**
     * @var string
     *
     * @ORM\Column(name="matiere", type="string", length=100, nullable=false)
     */
    private $matiere;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_pub", type="date", nullable=false)
     */
    private $datePub;

    /**
     * @var string
     *
     * @ORM\Column(name="fichier", type="blob", nullable=false)
     */
    private $fichier;


}

