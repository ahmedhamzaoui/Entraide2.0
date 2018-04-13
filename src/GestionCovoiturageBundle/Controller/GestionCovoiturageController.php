<?php

namespace GestionCovoiturageBundle\Controller;

use GestionCovoiturageBundle\Entity\Covoiturage;
use GestionCovoiturageBundle\Entity\Reservationcovoiturage;
use GestionCovoiturageBundle\Form\ReserverType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\UserBundle;

class GestionCovoiturageController extends Controller
{
    public function CovoiturageAction()
    {
        return $this->render('GestionCovoiturageBundle:Default:AcceuilCovoiturage.html.twig');
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $covoiturages = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAll();

        return $this->render('GestionCovoiturageBundle:Default:index.html.twig', array(
            'covoiturage' => $covoiturages,
        ));
    }

    public function ListAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        $covoiturages = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAll();

        return $this->render('GestionCovoiturageBundle:Default:CovoiturageBack.html.twig', array(
            'covoiturage' => $covoiturages,
        ));
}


    public function detailAction(Request $request,$id,$iduser)
    {

        $em = $this->getDoctrine()->getManager();
        $covoiturages = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($id);
        $user = $em->getRepository('UserBundle:Utilisateur')->findOneBy(["id"=>$iduser]) ;
        $res = new Reservationcovoiturage();
        $form = $this->createForm(ReserverType::class, $res);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user1 = $this->getUser();
        //
        //  $pro = $em->getRepository('UserBundle:Utilisateur')->find($user);//accés à l'entité User
        $nbp=$form["nbplaces"]->getData();
        $col = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($id);//Accés à l'entité logement à travers getRepository

        if ($form->isSubmitted()) {
            if($user1) {
            if ($col->getNbrplaces() > 0 && $col->getNbrplaces()>=$nbp) {

                    $res->setIdAnnonce($col);
                    $res->setIdReserve($user1);
                    $res->setIdChauffeur($col->getIdUser());
                    $res->setEtat(false);
                    $res->setNbplaces($nbp);
                    $em->persist($res);
                    $em->flush();
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Votre Demande a été envoyer avec succes');
                }
                else if ($col->getNbrplaces()<$nbp)
                {
                    $this->get('session')
                        ->getFlashBag()
                        ->add('info', 'Attention ! Nombre de places invalide');
                }


            } else {
                return $this->redirectToRoute('fos_user_security_login') ;

            }
        }
        $coov = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findBy(array('idUser'=>$iduser));//Accés à l'entité logement à travers getRepository
            $cnt = count($coov) ;
        return $this->render('@GestionCovoiturage/Default/detailcov.htm.twig', array(
            'covoiturage' => $covoiturages,
            'user'=>$user,
            'c' =>$form->createView() ,
            'count' => $cnt ,


        ));
    }



    public function newAction(Request $request)
    {
        $covoiturage = new Covoiturage();
        $user= $this->getUser() ;
        if($request->isMethod('POST')){
            if(!$user){
                return $this->redirectToRoute('fos_user_security_login') ;
            }

            $heure = $request->get('heure1').':'.$request->get('heure2').':00' ;
            $covoiturage->setDepart($request->get('depart')) ;
            $covoiturage->setArrive($request->get('arrive')) ;
            $covoiturage->setPrix($request->get('prix')) ;
            $covoiturage->setDate(new \DateTime($request->get('date'))) ;
            $covoiturage->setDateSys(new \DateTime('now')) ;
            $covoiturage->setHeure(new \DateTime($heure)) ;
            $covoiturage->setNbrplaces($request->get('place')) ;
            $covoiturage->setComfort($request->get('comfort')) ;
            $covoiturage->setFumeur($request->get('fumeur')) ;
            $covoiturage->setIdUser($this->getUser()) ;
            $time = new \DateTime();
            $time->format('H:i:s \O\n Y-m-d');
                if ((new \DateTime($request->get('date')) >= $time)&&$request->get('fumeur')!=null&&$request->get('comfort')!=null&&$request->get('place')!=null&&$request->get('prix')!=null&&$request->get('depart')!=null&&$request->get('arrive')!=null)
                {
            $em = $this->getDoctrine()->getManager();
            $em->persist($covoiturage);
            $em->flush() ;
                    $this->get('session')
                        ->getFlashBag()
                        ->add('info', 'Ajout effectué Avec succes !');
                }
else if(new \DateTime($request->get('date')) < $time) {
    $this->get('session')
        ->getFlashBag()
        ->add('info', 'Veuillez Verifier la date ');
}
else {
    $this->get('session')
        ->getFlashBag()
        ->add('info', 'Les champs précédés d\'un astérisque sont obligatoires ');
}
        }
        return $this->render('GestionCovoiturageBundle:Default:AjoutCovoiturage.html.twig',array()) ;
        }


public function editAction(Request $request, Covoiturage $covoiturage)
{
    $editForm = $this->createForm('GestionCovoiturageBundle\Form\CovoiturageType', $covoiturage);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('mes_covoiturage', array('id' => $covoiturage->getId()));
    }

    return $this->render('@GestionCovoiturage/Default/ModifierCovoiturage.html.twig', array(
        'covoiturage' => $covoiturage,
        'edit_form' => $editForm->createView(),
    ));
}

    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Covoiturage entity.');
        }

        $em->remove($entity);

        $em->flush();



        return $this->redirect($this->generateUrl('mes_covoiturage'));
    }
    public function deleteBackAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Covoiturage entity.');
        }

        $em->remove($entity);

        $em->flush();



        return $this->redirect($this->generateUrl('ListCovAdmin'));
    }


    public function MalisteAction(Request $request)
    {
        $user = $this->getUser();

if (!$user){
    return $this->redirectToRoute('fos_user_security_login') ;
}

        $em = $this->getDoctrine()->getManager();

        $listeCovoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findBy(array('idUser'=>$user));
        $covoiturage  = $this->get('knp_paginator')->paginate(
            $listeCovoiturage,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            3/*nbre d'éléments par page*/
        );
        if ($listeCovoiturage == null)
        {
            return $this->render('@GestionCovoiturage/Default/MesCovoiturage.html.twig', array(
                'covoiturages' => $listeCovoiturage,
                'covoiturage' => $covoiturage,));
        }
        return $this->render('@GestionCovoiturage/Default/MesCovoiturage.html.twig', array(
            'covoiturages' => $listeCovoiturage,

            'covoiturage' => $covoiturage,));

}



    public function RechercheAction(Request $request)
    {
            $user= $this->getUser();
            $covoiturage=null ;

        if ($request->isMethod('POST')){

            $em = $this->getDoctrine()->getManager();
            $depart = $request->get('depart');
            $arrive = $request->get('arrive');
            $date = $request->get('date');


            //$annonce = $em->getRepository('KarhabtyBundle:Annonces')->findAll();

            if($depart != null && $arrive != null && $date != null) {

                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnonces($depart, $arrive, $date);
                if ($covoiturage==null)
                {
                    return $this->render("@GestionCovoiturage/Default/ErreurRecherche.html.twig");

                }
                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage , 'user'=>$user));

            }
            else if ($depart==null&&$arrive==null&&$date==null)
            {
                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesAll();

                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage,'user'=>$user));
            }
            else if ($depart==null&&$arrive==null&&$date!=null)
            {
                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesDate($date);
                if ($covoiturage==null)
                {

                    return $this->render("@GestionCovoiturage/Default/ErreurRecherche.html.twig");

                }
                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage , 'user'=>$user));

            }
            else if ($depart!=null&&$arrive==null&&$date!=null)
            {
                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesDepart($depart, $date);
                if ($covoiturage==null)
                {
                    return $this->render("@GestionCovoiturage/Default/ErreurRecherche.html.twig");

                }
                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage , 'user'=>$user));

            }
            else if($depart==null&&$arrive!=null&&$date!=null)
            {
                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesArrive( $arrive, $date);
                if ($covoiturage==null)
                {
                    return $this->render("@GestionCovoiturage/Default/ErreurRecherche.html.twig");

                }
                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage , 'user'=>$user));

            }
            else if($depart==null&&$arrive!=null&&$date==null)
            {
                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesArriv( $arrive);
                if ($covoiturage==null)
                {
                    return $this->render("@GestionCovoiturage/Default/ErreurRecherche.html.twig");

                }
                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage , 'user'=>$user));

            }
            else if($depart!=null&&$arrive==null&&$date==null)
            {
                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesDepar( $depart);
                if ($covoiturage==null)
                {
                    return $this->render("@GestionCovoiturage/Default/ErreurRecherche.html.twig");

                }
                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage , 'user'=>$user));

            }
            else if($depart!=null&&$arrive!=null&&$date==null)
            {
                $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesDepartArrive( $depart,$arrive);
                if ($covoiturage==null)
                {
                    return $this->render("@GestionCovoiturage/Default/ErreurRecherche.html.twig");

                }
                return $this->render("@GestionCovoiturage/Default/index.html.twig", array('covoiturage' => $covoiturage , 'user'=>$user));

            }
        }
        return $this->render("@GestionCovoiturage/Default/index.html.twig",array('covoiturage'=>$covoiturage , 'user' => $user));


    }
    public function RecherchePrixAction(Request $request)
    {
            $covoiturage = new Covoiturage();
                $user=$this->getUser() ;
        $prMin=$request->get('prixMin');
        $prMax=$request->get('prixMax');
        if ($request->isMethod('POST')) {
            $prMin=$request->get('prixMin');
            $prMax=$request->get('prixMax');
            $covoiturage->setPrix($prMin);
            $covoiturage->setPrix($prMax);
            if($prMax<$prMin) {
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Attention le prix maximum doit etre superieur au prix minimum');
            }
             else if ($prMin != null && $prMax != null) {
                $covoiturage = $this->getDoctrine()->getRepository('GestionCovoiturageBundle:Covoiturage')
                    ->findByp($prMin, $prMax);

                return $this->render('@GestionCovoiturage/Default/index.html.twig', array(
                    'covoiturage' => $covoiturage,
                    'user' => $user
                ));
            }

            else if ($prMin != null && $prMax != null) {
                $covoiturage = $this->getDoctrine()->getRepository('GestionCovoiturageBundle:Covoiturage')
                    ->findByp(0, 100);

                return $this->render('@GestionCovoiturage/Default/index.html.twig', array(
                    'covoiturage' => $covoiturage,
                    'user' => $user
                ));
            } else if ($prMin == null && $prMax != null) {
                $covoiturage = $this->getDoctrine()->getRepository('GestionCovoiturageBundle:Covoiturage')
                    ->findByp(0, $prMax);

                return $this->render('@GestionCovoiturage/Default/index.html.twig', array(
                    'covoiturage' => $covoiturage,
                    'user' => $user
                ));
            }else if ($prMin != null && $prMax == null) {
                $covoiturage = $this->getDoctrine()->getRepository('GestionCovoiturageBundle:Covoiturage')
                    ->findByp($prMin, 100);

                return $this->render('@GestionCovoiturage/Default/index.html.twig', array(
                    'covoiturage' => $covoiturage,
                    'user' => $user
                ));
            }
        }
        $covoiturage = $this->getDoctrine()->getRepository('GestionCovoiturageBundle:Covoiturage')->findAll();
        return $this->render('@GestionCovoiturage/Default/index.html.twig', array(
            'covoiturage' => $covoiturage,
            'user' => $user
        ));

    }

    public function ContactAction()
    {
        $user=$this->getUser() ;
        if ($user){
        //returns an instance of Vresh\TwilioBundle\Service\TwilioWrapper
        $twilio = $this->get('twilio.api');
        $user= $this->getUser();
        $message = $twilio->account->messages->sendMessage(
            '+18443427816', // From a Twilio number in your account
            '+21658365637', // Text any number
            "Mr/Mme ".$user->getNom()." ".$user->getPrenom()." Souhaite vous contacter "
        );

        //get an instance of \Service_Twilio
        $otherInstance = $twilio->createInstance('BBBB', 'CCCCC');
        $em = $this->getDoctrine()->getManager();

        $covoiturage = $em->getRepository('GestionCovoiturageBundle:Covoiturage')->findAnnoncesAll();

        return $this->render('GestionCovoiturageBundle:Default:MessageSucces.html.twig') ;
        }
       return $this->redirectToRoute('fos_user_security_login') ;
    }

}
