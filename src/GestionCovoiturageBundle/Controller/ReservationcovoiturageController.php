<?php

namespace GestionCovoiturageBundle\Controller;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\OptimisticLockException;
use GestionCovoiturageBundle\Entity\Reservationcovoiturage;
use GestionCovoiturageBundle\Form\ReserverType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReservationcovoiturageController extends Controller
{
    public function AjouterReservationAction(Request $request,$id)
    {
        $res = new Reservationcovoiturage();
        $form = $this->createForm(ReserverType::class, $res);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();//
        //  $pro = $em->getRepository('UserBundle:Utilisateur')->find($user);//accés à l'entité User
        $nbp=$form["nbplaces"]->getData();
        $col = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($id);//Accés à l'entité logement à travers getRepository
        if ($form->isSubmitted()) {
            if ($col->getNbrplaces() > 0) {
                $res->setIdAnnonce($col);
                $res->setIdReserve( $user);
                $res->setIdChauffeur($col->getIdUser());
                $res->setEtat(false);
                $res->setNbplaces($nbp);


                $em->persist($res);
                $em->flush();

            }
        }
        return $this->render('@GestionCovoiturage/Default/detailcov.htm.twig',
            array('c' => $form->createView()));
    }
    public function affResAction()
    {
        $user = $this->getUser() ;
        if (!$user){
            return $this->redirectToRoute('fos_user_security_login') ;
        }
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('GestionCovoiturageBundle:Reservationcovoiturage')->findBy(array('IdReserve'=>$user));

        return $this->render('@GestionCovoiturage/Default/MesReservations.html.twig', array(
            'cov'=>$res
        ));
    }

    public function AnnulerResAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $reservation = $em->getRepository('GestionCovoiturageBundle:Reservationcovoiturage')->find($id);
        $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($reservation->getIdAnnonce());
        if ($reservation->getEtat()==true)
        {
            $covoiturage->setNbrplaces($covoiturage->getNbrplaces()+$reservation->getNbplaces()) ;
        }
        $em->remove($reservation);
        $em->flush();
        return $this->redirectToRoute('mesreservationcov');
    }
    public function declinerResAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $reservation = $em->getRepository('GestionCovoiturageBundle:Reservationcovoiturage')->find($id);
        $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($reservation->getIdAnnonce());
        if ($reservation->getEtat()==false)
        {
            $em->remove($reservation);

        }
        if ($reservation->getEtat()==true)
        {
            $covoiturage->setNbrplaces($covoiturage->getNbrplaces()+$reservation->getNbplaces()) ;
            $reservation->setEtat(false) ;
        }

        $em->flush();
        return $this->redirectToRoute('mesdemandereservationcov');
    }
    public function declinerResAdminAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $reservation = $em->getRepository('GestionCovoiturageBundle:Reservationcovoiturage')->find($id);
        $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($reservation->getIdAnnonce());

            $em->remove($reservation);


        $em->flush();
        return $this->redirectToRoute('ListResAdmin');
    }
    public function AffDemandeResAction()
    {
        $user = $this->getUser() ;
        if (!$user){
            return $this->redirectToRoute('fos_user_security_login') ;
        }
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $res = $em->getRepository('GestionCovoiturageBundle:Reservationcovoiturage')->findBy(array('IdChauffeur'=>$user));
        return $this->render('@GestionCovoiturage/Default/MesReservationsRecu.html.twig', array(
            'cov'=>$res
        ));
    }
    public function ListResAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reservation = $em->getRepository('GestionCovoiturageBundle:Reservationcovoiturage')->findAll();

        return $this->render('GestionCovoiturageBundle:Default:ReservationBack.html.twig', array(
            'reservation' => $reservation,
        ));
    }
    public function AccepterReservationAction($id,$idc)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository('GestionCovoiturageBundle:Reservationcovoiturage')->find($id);
        $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($idc);
        $user1 = $em->getRepository('UserBundle:Utilisateur')->find($covoiturage->getIdUser());
                        $reservation->setEtat(true);
                        $covoiturage->setNbrplaces($covoiturage->getNbrplaces()-$reservation->getNbplaces()) ;
                        $em->flush();


        return $this->redirectToRoute('mesdemandereservationcov');
    }

    public function sendNotifAction(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Demande de covoiturage accepté');
        $notif->setMessage('Demande accepté par');
        $notif->setLink('');
        $manager->addNotification($this->getUser(),$notif,true);


    }


}
