<?php

namespace ColocationBundle\Controller;

use ColocationBundle\Entity\Colocation;
use ColocationBundle\Entity\Reservationcolocation;
use ColocationBundle\Form\ReserverType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class ReservationcolocationController extends Controller
{
    public function purgeAction(Request $request)
    {
        // On récupère notre service//config/services
        $purger = $this->get('colocation.reservation_purger');
//maryem
        // On purge les réservations
        $purger->purge(3);//effacer les reservations qui ne sont pas confirmés pendant 3jrs

        // On ajoute un message flash arbitraire

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Félicitations, les réservations plus vieilles que 3 jours ont été purgées ');
        // On redirige vers la page d'accueil

        return $this->redirect($this->generateUrl('colocation_chercher'));//?!

    }

    public function AjouterReservationAction(Request $request,$id)
    {
        $res = new Reservationcolocation();
        $form = $this->createForm(ReserverType::class, $res);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
       // $user = $this->getUser();//
      //  $pro = $em->getRepository('UserBundle:Utilisateur')->find($user);//accés à l'entité User
        $nbp=$form["nbplace"]->getData();
        $col = $em->getRepository('ColocationBundle:Colocation')->find($id);//Accés à l'entité logement à travers getRepository
        $mm=$col->getIdUser()->getId();
        if ($form->isSubmitted()) {
            $u=$this->getUser()->getId();
            if($u != $mm){
            if ($col->getNbpersonne() > 0 && $col->getNbpersonne()>= $nbp ) {
                $res->setConfirmation(false);
                $res->setIdColocation($col);
                $res->setIdUser($this->getUser());
                $date = new \DateTime();
                $res->setExpiredate($date);
                $em->persist($res);
                $em->flush();
                $var = $col->getIdUser();
                $manager = $this->get('mgilet.notification');
                $notif = $manager->createNotification('Demande De Reservation');
                $notif->setMessage('Je Veux Réserver');
                $notif->setLink('');
                $manager->addNotification(array($var), $notif, true);
            }
        }
        }
        return $this->render('ColocationBundle:Colocation:reservation.html.twig',
            array('c' => $form->createView()));
    }

    public function confirmerAction($id)
    {
        $user=$this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $myAn = $em->getRepository('ColocationBundle:Colocation')->findBy(array('idUser'=>$user));
        $resuser = $em->getRepository('ColocationBundle:Reservationcolocation')->findBy(array('idColocation'=>$myAn));
        $res = new Reservationcolocation();

        $ress = $this->getDoctrine()
            ->getRepository('ColocationBundle:Reservationcolocation')
            ->find($id);
        $id_col= $ress-> getIdColocation();
        $nbp=$ress->getNbplace();
        $col = $em->getRepository('ColocationBundle:Colocation')->find($id_col);
        if ($col->getNbpersonne() > 0 && $col->getNbpersonne()>= $nbp ){
               $col->setNbpersonne($col->getNbpersonne() - $nbp);
                $ress->setConfirmation(true);
                $em->persist($ress);
                $em->flush();

            }

        return $this->render('ColocationBundle:Colocation:listReservations.html.twig', array(
            'resuser'=>$resuser
        ));
    }

    public function affMesReseAction()
    {
        $user=$this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $ress = $em->getRepository('ColocationBundle:Reservationcolocation')->findBy(array('idUser'=>$user));
        return $this->render('ColocationBundle:colocation:MesReservations.html.twig', array(
            'ress'=>$ress
        ));
    }

    public function afflistReseAction()
    {
        $user=$this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $myAn = $em->getRepository('ColocationBundle:Colocation')->findBy(array('idUser'=>$user));
        $resuser = $em->getRepository('ColocationBundle:Reservationcolocation')->findBy(array('idColocation'=>$myAn));

        return $this->render('ColocationBundle:colocation:listReservations.html.twig', array(
            'resuser'=>$resuser
        ));
    }
    public function refuserRAction($id)
    {
        //$res = new Reservationcolocation();


        $res = $this->getDoctrine()
            ->getRepository('ColocationBundle:Reservationcolocation')
            ->find($id);
        $id_col= $res-> getIdColocation();
        $em = $this->getDoctrine()->getManager();
        $col = $em->getRepository('ColocationBundle:Colocation')->find($id_col);
        $nbr1=$res->getNbplace();
        $col->setNbpersonne($col->getNbpersonne() + $nbr1);
        $em->remove($res);
        $em->flush();
        return $this->redirectToRoute('user_affiche_res');

    }
    public function SupprimerRAction($id)
    {
        //$res = new Reservationcolocation();


        $res = $this->getDoctrine()
            ->getRepository('ColocationBundle:Reservationcolocation')
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($res);
        $em->flush();
        return $this->redirectToRoute('colocation_affiche_mesreservations');

    }
}
