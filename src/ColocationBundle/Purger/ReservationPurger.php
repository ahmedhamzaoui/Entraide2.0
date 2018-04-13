<?php
// src/Purger/ReservationPurger.php

namespace ColocationBundle\Purger;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class ReservationPurger
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    // On injecte l'EntityManager
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function purge($days)
    {
        // date d'il y a $days jours


        $date = new \Datetime($days . ' days ago');
        $date;
       // return new Response($date);
        //$date1 = new \DateTime();


        //return new Response("".$date);
        //dump($date);

        // On récupère les réservations à supprimer
        $listAdverts = $this->em->getRepository('ColocationBundle:Reservationcolocation')->getreservationBefore($date);

        // On parcourt les reservations pour les supprimer effectivement
        foreach ($listAdverts as $advert) {
            $this->em->remove($advert);
        }

        // Et on n'oublie pas de faire un flush !
        $this->em->flush();
    }
}
