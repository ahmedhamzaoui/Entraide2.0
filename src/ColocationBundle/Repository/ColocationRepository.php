<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 26/03/2018
 * Time: 23:42
 */

namespace ColocationBundle\Repository;



class ColocationRepository extends \Doctrine\ORM\EntityRepository
{

    public function findByAd($mot)
    {
        $q = $this->getEntityManager()
            ->createQuery("SELECT v FROM ColocationBundle:Colocation v WHERE v.adresse LIKE '%".$mot."%'");
        return $q->getResult();
    }


    public function findByp($prixMin,$prixMax)

    {

        $query = $this->createQueryBuilder('a');

        $query->where('a.prix BETWEEN :prixMin AND :prixMax')
            ->setParameter('prixMin', $prixMin)
            ->setParameter('prixMax', $prixMax);

        return $query->getQuery()->getResult();
    }

    public  function rechercheAjax($ses){
        return $this->createQueryBuilder('colcation')
            ->where('colocation.typeLog LIKE  :ses')
            ->setParameter('ses', '%' . $ses . '%')
            ->getQuery()
            ->getResult();
    }


}
