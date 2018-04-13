<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 07/04/2018
 * Time: 16:29
 */

namespace ReclamationBundle\Repository;


class ReclamationRepository extends \Doctrine\ORM\EntityRepository
{
    public  function rechercheAjax($ses){
        return $this->createQueryBuilder('x')
            ->where('x.type LIKE  :ses')
            ->setParameter('ses', '%' . $ses . '%')
            ->getQuery()
            ->getResult();
    }
    public function DeleteApresExpiration($dateDecouverte){

        $date = date('Y-m-d h:i:s', strtotime("+30 days"));
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.dateDecouverte NOT BETWEEN :today AND :dateDec')
            ->setParameter('dateDec',$dateDecouverte)
            ->setParameter('today', date('Y-m-d h:i:s'))
           // ->setParameter('n30days', $date)
            ->getQuery()
            ->getArrayResult();
    }
    public function getreservationBefore($date)
    {
        return $this->createQueryBuilder('a')
            ->where('a.expiredate < :date')// Date de modification antérieure à :date
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult();
    }


}