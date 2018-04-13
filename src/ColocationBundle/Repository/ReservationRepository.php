<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 12/04/2018
 * Time: 19:11
 */

namespace ColocationBundle\Repository;


class ReservationRepository extends \Doctrine\ORM\EntityRepository
{
    public function getreservationBefore($date)
    {
        return $this->createQueryBuilder('a')
            ->where('a.expiredate < :date')// Date de modification antérieure à :date
            ->andWhere('a.confirmation=false')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }
}