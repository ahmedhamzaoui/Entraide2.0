<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 04/04/2018
 * Time: 00:22
 */

namespace ReclamationBundle\Repository;


class UtilisateurRepository extends \Doctrine\ORM\EntityRepository
{

    public function FindUser($matricule)
    {
        $q = $this->createQueryBuilder('m');
        $q->where('m.matricule = :matricule')
            ->setParameter('matricule', $matricule);
        return $q->getQuery()->getResult();
    }
    public function FindUserContact($id)
    {
        $q = $this->createQueryBuilder('m');
        $q->where('m.id = :id')
            ->setParameter('id', $id);
        return $q->getQuery()->getResult();
    }
}