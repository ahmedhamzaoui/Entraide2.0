<?php
/**
 * Created by PhpStorm.
 * User: nadaghanem
 * Date: 24/03/2018
 * Time: 21:30
 */

namespace RevisionBundle\Controller;


use RevisionBundle\Entity\ReservationSalle;
use RevisionBundle\Form\CoursType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use RevisionBundle\Entity\Cours;
use Symfony\Component\HttpFoundation\Response;


class RevisionController extends Controller
{
    public function ajouterAction(Request $request)
    {
        $cours = new Cours();

        $form = $this->createFormBuilder($cours)
            ->add('matiere', TextType::class)
            ->add('module', TextType::class)
            ->add('fichier', FileType::class, array('data_class' => null))
            ->add('ajouter', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $cours->setDatePub(new \DateTime('now'));
            $file = $form['fichier']->getData();
            $cours = $form->getData();
            $file->move('uploads/images/', $file->getClientOriginalName());
            $cours->setFichier("uploads/images/" . $file->getClientOriginalName());


            $cours = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($cours);
            $em->flush();


            return $this->redirectToRoute("revision_ajout");

        }

        return $this->render('@Revision/Default/ajoutR.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function afficheAction()
    {

        $em = $this->getDoctrine()->getManager();
        $courss = $em->getRepository(\RevisionBundle\Entity\Cours::class)->findAll();
        return $this->render('@Revision/Default/affiche.html.twig', array(
            'courss' => $courss
        ));
    }

    public function updateAction(Request $request, $id)

    {

        $em = $this->getDoctrine();
        $cours = $em->getRepository("RevisionBundle:Cours")->find($id);

        $form = $this->createForm(CoursType::class, $cours);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $cours->setDatePub(new \DateTime('now'));

            $em = $this->getDoctrine()->getManager();

            $em->persist($cours);
            $em->flush();
            return $this->redirectToRoute("revision_aff");
        }
        return $this->render('@Revision/Default/updateR.html.twig', array('form' => $form->createView()));


    }


    public function deleteEAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cours = $em->getRepository(\RevisionBundle\Entity\Cours::class)->find($id);
        $em->remove($cours);
        $em->flush();

        return $this->redirectToRoute('revision_aff');
    }

    public function mycourseAction(Request $request)
    {
        $user = $this->getUser();
        $idb = $user->getId();


        $mycourse = $this->getDoctrine()->getManager()->getRepository(Cours::class)
            ->findByIdu($idb);


        return $this->render('@Revision/Default/mycourse.html.twig', array('mycourse' => $mycourse));
    }


    public function rechercheAjaxAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();

        $em=$this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $search  = $request->get('search');
            dump($search);
            $courss = new Cours();
            $repo  = $em->getRepository('RevisionBundle:Cours');
            $courss = $repo->findAjax($search);
            return $this->render('@Revision/Default/searchDql.html.twig', array('courss' => $courss));
        }


    }

    public function reservation_valideAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(\RevisionBundle\Entity\ReservationSalle::class)->find($id);
        $reservation->setEtat(1);

        $em->persist($reservation);
        $em->flush();
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 25, 'tls')
            ->setUsername('nada.ghannem')
                ->setPassword('nodnodghannem3a9esprit')
                ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
            $mailer = new \Swift_Mailer($transport);
            $body="Merci pour votre reservation";
            $message=(new \Swift_Message('salle disponible'))
                ->setFrom('nada.ghannem@esprit.tn')
                 ->setTo('farah.falleh@esprit.tn')
                ->setContentType('text/html')
                ->setBody($body);

           $mailer->send($message);


        return $this->redirectToRoute('admin');
    }

    public function ajouterReservationAction(Request $request)
    {
        $user=$this->getUser();
        $iduser=$user->getId();
        $reservation = new ReservationSalle();

        $form = $this->createFormBuilder($reservation)
            ->add('user',TextType::class)
            ->add('salle',TextType::class)
            ->add('dateTime1',TimeType::class)
            ->add('dateTime2',TimeType::class)
            ->add('nbPersonnes',TextType::class)

            ->add('save',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $reservation = $form->getData();


            $em = $this->getDoctrine()->getManager();
            $reservation->setEtat(0);
            $reservation->setIdConnecte($iduser);
            $em->persist($reservation);
            $em->flush();

            return $this->redirectToRoute("reservation_salle");

        }

        return $this->render('@Revision/Default/reserversalle.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function adminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $reservation= $em->getRepository(\RevisionBundle\Entity\ReservationSalle::class)->findAll();
        return $this->render('@Revision/Default/admin.html.twig', array(
            'reservation'=>$reservation
        ));

    }

    public function voir_reservationAction()
    {
        $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(\RevisionBundle\Entity\ReservationSalle::class)->findAll();
        $array=array();

        foreach ($reservation as $reserv)
        {
            if($reserv->getEtat()==1)
            {
                array_push($array,$reserv);
            }

        }
        return $this->render('@Revision/Default/voirReservation.html.twig', array(
            'valide' => $array
        ));

    }

    public function pdfAction()
    {
       $em = $this->getDoctrine()->getManager();
        $reservation = $em->getRepository(\RevisionBundle\Entity\ReservationSalle::class)->findAll();
        $array=array();

        foreach ($reservation as $reserv)
        {
            if($reserv->getEtat()==1)
            {
                array_push($array,$reserv);
            }

        }
        $snappy = $this->get('knp_snappy.pdf');

        $html = $this->renderView('@Revision/Default/pdf.html.twig',
            array('valide' => $array
            //..Send some data to your view if you need to //
        ));

        $filename = 'MonPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . "$filename" . '.pdf"'
            )
        );
//        return $this->render('@Revision/Default/pdf.html.twig', array(
//            'valide' => $array
//        ));
    }

}