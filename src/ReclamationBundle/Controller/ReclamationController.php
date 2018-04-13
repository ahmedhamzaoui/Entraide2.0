<?php

namespace ReclamationBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use ReclamationBundle\Entity\Mail;
use ReclamationBundle\Entity\Reclamation;
use ReclamationBundle\Form\MatriculeType;
use ReclamationBundle\Form\rechaffichertoutesType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use UserBundle\Entity\Utilisateur;
use ReclamationBundle\Form\addMalType;
use ReclamationBundle\Form\rechercheMalType;
use ReclamationBundle\Form\rechercheType;
use ReclamationBundle\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReclamationController extends Controller
{

    public function purgeAction(Request $request)
    {
        // On récupère notre service//config/services
        $purger = $this->get('reclamation.reservation_purger');
//maryem
        // On purge les réservations
        $purger->purge(15);//effacer les reservations qui ne sont pas confirmés pendant 3jrs

        // On ajoute un message flash arbitraire

        $request->getSession()
            ->getFlashBag()
            ->add('success', 'Félicitations, les réservations plus vieilles que 3 jours ont été purgées ');
        // On redirige vers la page d'accueil

        return $this->redirect($this->generateUrl('recherche'));//?!

    }



    public function addAction(Request $request)
    {
        $Reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $Reclamation);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $user=$this->getUser();
        $error="";
        if ($form->isSubmitted()) {
            $date = new \DateTime();

            $date2 = new \Datetime(10 . ' days ago');



            $date_d = $Reclamation->getDateDecouverte();
            if ($date2<$date_d){
                //return new Response("Error");
                //return new Response($Reclamation->getDateDecouverte());
                $Reclamation->setExpiredate($date);
                $Reclamation->setIdUser($user);
                $file = $Reclamation->getPhoto();
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName);
                $Reclamation->setPhoto($fileName);
                // $Reclamation->setCreatedBy($user->getEmail());
                $em->persist($Reclamation);
                $em->flush();
                return $this->redirectToRoute('recherche');
            }
            else{
                //return new Response("All good");
                $error = "veuillez entrer une date valide";
                return $this->render('ReclamationBundle:Reclamation:add.html.twig',
                    array('c' => $form->createView(),'error'=>$error));
            }


        }

        return $this->render('ReclamationBundle:Reclamation:add.html.twig',
            array('c' => $form->createView(),'error'=>$error));
    }

    public function afficherAction()
    {
        $em = $this->getDoctrine()->getManager();
            $Reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findBy(array('type' => array('Reclamation Objet Trouvé','Reclamation Objet Perdu')));
            return $this->render('ReclamationBundle:Reclamation:afficher.html.twig',
                array('ca' => $Reclamation)
            );
    }


    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        $form = $this->createForm('ReclamationBundle\Form\editType', $Reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $file3 = $Reclamation->getPhoto();
            $fileName3 = $this->generateUniqueFileName() . '.' . $file3->guessExtension();
            $file3->move(
                $this->getParameter('images_directory'),
                $fileName3);
            $Reclamation->setPhoto($fileName3);
           $em->persist($Reclamation);
            $em->flush();
            return $this->redirectToRoute('recherche');

        }
        return $this->render('ReclamationBundle:Reclamation:edit.html.twig', array('form' => $form->createView()));

    }

    public function deleteAction($id)
    {
        $Reclamation = $this->getDoctrine()
            ->getRepository('ReclamationBundle:Reclamation')
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($Reclamation);
        $em->flush();
        return $this->redirectToRoute('recherche');

    }

    public function rechercheAction(Request $request)
    {

        $Reclamation = new Reclamation();
        $user=$this->getUser()->getId();
        $form = $this->createForm(rechercheType::class, $Reclamation);
        $Reclamations = $this->getDoctrine()->getRepository('ReclamationBundle:Reclamation')->findBy(array('type' => array('Reclamation Objet Trouvé','Reclamation Objet Perdu'),'validation'=>array('1'),'etat'=>array(NULL),'idUser'=>array($user)));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $Reclamation->getTypeobjPerdu() != null && $Reclamation->getType() != null) {
            $Reclamations = $this->getDoctrine()->getRepository('ReclamationBundle:Reclamation')->findBy(array('typeobjPerdu' => $Reclamation->getTypeobjPerdu(),'type'=>$Reclamation->getType()));
        }
        return $this->render('ReclamationBundle:Reclamation:recherche.html.twig', array(
            'Reclamations' => $Reclamations, 'form' => $form->createView()
        ));
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    public function addMalAction(Request $request)
    {
        $Reclamation = new Reclamation();
        $Reclamation->setType("Reclamation mal stationnement");
        $form = $this->createForm(addMalType::class, $Reclamation);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted()) {
            $file2 = $Reclamation->getPhoto2();
            $fileName2 = $this->generateUniqueFileName() . '.' . $file2->guessExtension();
            $file2->move(
                $this->getParameter('images_directory'),
                $fileName2);
            $Reclamation->setPhoto2($fileName2);

            $em->persist($Reclamation);
            $em->flush();
            return $this->redirectToRoute('rechercheMal');

        }

        return $this->render('ReclamationBundle:Reclamation:addMal.html.twig',
            array('c' => $form->createView()));
    }

    public function editMalAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        $form = $this->createForm('ReclamationBundle\Form\editMalType', $Reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $file4 = $Reclamation->getPhoto2();
            $fileName4 = $this->generateUniqueFileName() . '.' . $file4->guessExtension();
            $file4->move(
                $this->getParameter('images_directory'),
                $fileName4);
            $Reclamation->setPhoto2($fileName4);
            $em->persist($Reclamation);
            $em->flush();
            return $this->redirectToRoute('rechercheMal');
        }
        return $this->render('ReclamationBundle:Reclamation:editMal.html.twig', array('form' => $form->createView()));

    }

    public function rechercheMalAction(Request $request)
    {

        $Reclamation = new Reclamation();
        $form = $this->createForm(rechercheMalType::class, $Reclamation);
        $Reclamations = $this->getDoctrine()->getRepository('ReclamationBundle:Reclamation')->findBy(array('type' => array('Reclamation mal stationnement'),'validation'=>array('1')));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $Reclamation->getMatricule() != null) {
            $Reclamations = $this->getDoctrine()->getRepository('ReclamationBundle:Reclamation')->findBy(array('matricule' => $Reclamation->getMatricule()));
        }
        return $this->render('ReclamationBundle:Reclamation:rechercheMal.html.twig', array(
            'Reclamations' => $Reclamations, 'form' => $form->createView()
        ));
    }

    public function deleteMalAction($id)
    {
        $Reclamation = $this->getDoctrine()
            ->getRepository('ReclamationBundle:Reclamation')
            ->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($Reclamation);
        $em->flush();
        return $this->redirectToRoute('rechercheMal');

    }

    public function acceuilRecAction(){
    return $this->render('ReclamationBundle:Reclamation:acceuilReclamation.html.twig');
    }


    public function indexAction()
    {
        $pieChart = new PieChart();
        $data2 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Calculatrice');
        $data3 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Chargeur');
        $data4 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Carte Etudiant');
        $data5 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Clés');
        $data6 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Clé USB');
        $data7 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('CIN');
        $data8 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Monnaie');
        $data9 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Passeport');
        $data10 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('PC');
        $data11 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Porte-feuilles');
        $data12 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Porte-documents');
        $data13 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Telephone');
        $data14 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Feuilles');
        $data15 = $this->getDoctrine()->getRepository(Reclamation::class)->findBytypeobjPerdu('Autre');

        $nb2=count($data2);
        $nb3=count($data3);
        $nb4=count($data4);
        $nb5=count($data5);
        $nb6=count($data6);
        $nb7=count($data7);
        $nb8=count($data8);
        $nb9=count($data9);
        $nb10=count($data10);
        $nb11=count($data11);
        $nb12=count($data12);
        $nb13=count($data13);
        $nb14=count($data14);
        $nb15=count($data15);


        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['Calculatrice',     $nb2],
                ['Chargeur',      $nb3],
                ['Carte Etudiant',      $nb4],
                ['Clés',      $nb5],
                ['Clé USB',      $nb6],
                ['CIN',      $nb7],
                ['Monnaie',      $nb8],
                ['Passeport',      $nb9],
                ['PC',      $nb10],
                ['Porte-feuilles',      $nb11],
                ['Porte-documents',      $nb12],
                ['Telephone',      $nb13],
                ['Feuilles',      $nb14],
                ['Autre',      $nb15]

            ]
        );
        $pieChart->getOptions()->setTitle('Reclamation par type objet');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('ReclamationBundle:Reclamation:piechart.html.twig', array('piechart' => $pieChart));
    }

    public function index2Action()
    {
        $reclamation =new Reclamation();
        $data2 = $this->getDoctrine()->getRepository(Reclamation::class)->findByType('Reclamation Objet Perdu');
        $data3 = $this->getDoctrine()->getRepository(Reclamation::class)->findByType('Reclamation Objet Trouvé');
        $data4 = $this->getDoctrine()->getRepository(Reclamation::class)->findByType('Reclamation mal stationnement');
        $nb2=count($data2);
        $nb3=count($data3);
        $nb4=count($data4);

        $oldColumnChart = new ColumnChart();
        $oldColumnChart->getData()->setArrayToDataTable(
            [
                ['Name', 'Reclamations'],
                ['Reclamation Objet Perdu', $nb2],
                ['Reclamation Objet Trouvé', $nb3],
                ['Reclamation mal stationnement', $nb4],
            ]
        );
        $oldColumnChart->getOptions()->getLegend()->setPosition('top');
        $oldColumnChart->getOptions()->setWidth(450);
        $oldColumnChart->getOptions()->setHeight(250);




        return $this->render('ReclamationBundle:Reclamation:barchart.html.twig', array(
            'oldColumnChart' => $oldColumnChart,
        ));
    }

    public function findByMatriculeAction(Request $request)
    {

        $mail = new Mail();
        $form3= $this->createForm(MatriculeType::class);
        $form3->handleRequest($request) ;
        $user = new Utilisateur();

        if ( $form3->isSubmitted() && $form3->isValid()) {
            $matricule=$form3["matricule"]->getData();
            $users = $this->getDoctrine()->getRepository('UserBundle:Utilisateur')
                ->FindUser($matricule);

            $first_value = reset($users);
            $adresse = $first_value->getEmail();
            $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 25, 'tls')
                ->setUsername('farahfalleh95')
                ->setPassword('2248019020711095')
                ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
            $mailer = new \Swift_Mailer($transport);
            $body="Bonjour,votre voiture est mal garée merci de venir la déplacer";
            $message=(new \Swift_Message('Voiture mal garée'))
                ->setFrom('farahfalleh95@gmail.com')
                ->setTo($adresse)
                ->setContentType('text/html')
                ->setBody($body);

            $mailer->send($message);

         return $this->redirect($this->generateUrl('my_app_mail_accuse'));


        }
        return $this->render('ReclamationBundle:Reclamation:mailmatricule.html.twig', array('form3' => $form3->createView()));

    }
    public function successAction(){
        return $this->render('ReclamationBundle:Reclamation:mailavecsucces.html.twig');
    }

    public function AfficherAdminAction()
    {
        $em=$this->getDoctrine()->getManager();
        $Reclamation=$em->getRepository("ReclamationBundle:Reclamation")->findBy(array('validation' => array(NULL)));

        return $this->render('ReclamationBundle:Reclamation:adminaffichage.html.twig',
            array('ca'=>$Reclamation)
        );
    }

    public function ValiderAdminAction($id)
    {

        $Reclamation=$this->getDoctrine()
            ->getRepository('ReclamationBundle:Reclamation')
            ->find($id);
        $Reclamation->setValidation("1");
        $em=$this->getDoctrine()->getManager();


        $Reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        $x=$Reclamation->getIdUser();
        $users = $this->getDoctrine()->getRepository('UserBundle:Utilisateur')
            ->FindUserContact($x);
        $first_value = reset($users);
        $adresse = $first_value->getEmail();
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 25, 'tls')
            ->setUsername('farahfalleh95')
            ->setPassword('2248019020711095')
            ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
        $mailer = new \Swift_Mailer($transport);
        $body="Votre reclamation a été validé par l'admin et publié, vous pouvez la consulter maintenant";
        $message=(new \Swift_Message('Validation admin'))
            ->setFrom('farahfalleh95@gmail.com')
            ->setTo($adresse)
            ->setContentType('text/html')
            ->setBody($body);

        $mailer->send($message);



        $em->persist($Reclamation);
        $em->flush();
        return $this->render('ReclamationBundle:Reclamation:contactcbon.html.twig');


    }
    public function deleteAdminAction($id)
    {
        $Reclamation=$this->getDoctrine()
            ->getRepository('ReclamationBundle:Reclamation')
            ->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($Reclamation);


        $Reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        $x=$Reclamation->getIdUser();
        $users = $this->getDoctrine()->getRepository('UserBundle:Utilisateur')
            ->FindUserContact($x);
        $first_value = reset($users);
        $adresse = $first_value->getEmail();
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 25, 'tls')
            ->setUsername('farahfalleh95')
            ->setPassword('2248019020711095')
            ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
        $mailer = new \Swift_Mailer($transport);
        $body="Malheuresement , Votre reclamation a été supprimé par l'admin vous pouvez réssayez de publier une autre bien formulé";
        $message=(new \Swift_Message('Validation admin'))
            ->setFrom('farahfalleh95@gmail.com')
            ->setTo($adresse)
            ->setContentType('text/html')
            ->setBody($body);

        $mailer->send($message);

        $em->persist($Reclamation);
        $em->flush();


        return $this->redirectToRoute('afficheradmin');

    }
    public function affichertoutesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $Reclamation = new Reclamation();
        $Reclamations = $em->getRepository("ReclamationBundle:Reclamation")->findBy(array('type' => array('Reclamation Objet Trouvé','Reclamation Objet Perdu'),'validation' => array('1')));
        $form = $this->createForm(rechaffichertoutesType::class, $Reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $Reclamation->getType() != null) {
            $Reclamations = $this->getDoctrine()->getRepository('ReclamationBundle:Reclamation')->findBy(array('type'=>$Reclamation->getType()));
        }
        return $this->render('ReclamationBundle:Reclamation:affichertoutes.html.twig',
            array('Reclamations' => $Reclamations, 'form' => $form->createView()));

    }
    public function affichertoutesMalAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository("ReclamationBundle:Reclamation")->findBy(array('type' => array('Reclamation mal stationnement'),'validation' => array('1')));
        return $this->render('ReclamationBundle:Reclamation:affichertoutesMal.html.twig',
            array('Reclamations' => $Reclamation)
        );
    }
    public function RecupererAction($id)
    {

        $Reclamation=$this->getDoctrine()
            ->getRepository('ReclamationBundle:Reclamation')
            ->find($id);
        $Reclamation->setEtat('recuperer');
        $em=$this->getDoctrine()->getManager();
        $em->persist($Reclamation);
        $em->flush();

        return $this->render('ReclamationBundle:Reclamation:recuperer.html.twig');

    }
    public function RenduAction($id)
    {

        $Reclamation=$this->getDoctrine()
            ->getRepository('ReclamationBundle:Reclamation')
            ->find($id);
        $Reclamation->setEtat('rendu');
        $em=$this->getDoctrine()->getManager();
        $em->persist($Reclamation);
        $em->flush();

        return $this->render('ReclamationBundle:Reclamation:rendu.html.twig');

    }
    public function index3Action()
    {
        $pieChart = new PieChart();
        $data2 = $this->getDoctrine()->getRepository(Reclamation::class)->findByetat('rendu');
        $data3 = $this->getDoctrine()->getRepository(Reclamation::class)->findByetat('recuperer');

        $nb2=count($data2);
        $nb3=count($data3);


        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['rendu',     $nb2],
                ['recuperé',      $nb3]

            ]
        );
        $pieChart->getOptions()->setTitle('Reclamation par état');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('ReclamationBundle:Reclamation:piechartEtat.html.twig', array('piechart' => $pieChart));
    }

    public function Contact1Action(Request $request,$id)
    {

        $user=$this->getUser()->getTelephone();
        $user2=$this->getUser()->getEmail();
        $em = $this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        $x=$Reclamation->getIdUser();
        $users = $this->getDoctrine()->getRepository('UserBundle:Utilisateur')
            ->FindUserContact($x);
        $first_value = reset($users);
      $adresse = $first_value->getEmail();
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 25, 'tls')
            ->setUsername('farahfalleh95')
            ->setPassword('2248019020711095')
            ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
        $mailer = new \Swift_Mailer($transport);
        $body="J'ai trouvé ton objet, voilà mon numéro vous pouvez me contacter    ".$user."  et mon adresse email  ".$user2;
        $message=(new \Swift_Message('Réponse à votre reclamation objet perdu'))
            ->setFrom('farahfalleh95@gmail.com')
            ->setTo($adresse)
            ->setContentType('text/html')
            ->setBody($body);

        $mailer->send($message);
        $em->persist($Reclamation);
        $em->flush();
        return $this->redirect($this->generateUrl('my_app_mail_accuse'));

    }
    public function Contact2Action(Request $request,$id)
    {

        $user=$this->getUser()->getTelephone();
        $user2=$this->getUser()->getEmail();
        $em = $this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        $x=$Reclamation->getIdUser();
        $users = $this->getDoctrine()->getRepository('UserBundle:Utilisateur')
            ->FindUserContact($x);
        $first_value = reset($users);
        $adresse = $first_value->getEmail();
        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 25, 'tls')
            ->setUsername('farahfalleh95')
            ->setPassword('2248019020711095')
            ->setStreamOptions(array('ssl' => array('allow_self_signed' => true, 'verify_peer' => false)));
        $mailer = new \Swift_Mailer($transport);
        $body="Salut,j'ai vu ta reclamation d'objet trouvé , En fait c'est le mien, voilà mon numéro vous pouvez me contacter    ".$user."  et mon adresse email  ".$user2;
        $message=(new \Swift_Message('Réponse à votre reclamation objet trouvé'))
            ->setFrom('farahfalleh95@gmail.com')
            ->setTo($adresse)
            ->setContentType('text/html')
            ->setBody($body);

        $mailer->send($message);
        $em->persist($Reclamation);
        $em->flush();
        return $this->redirect($this->generateUrl('my_app_mail_accuse'));

    }
    public function rechercheajaxAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $reclamations = $this->getDoctrine()->getRepository('ReclamationBundle:Reclamation')->findAll();
        if ($request->isXmlHttpRequest()) {
            $ses=$request->get('s');
            $reclamations=$em->getRepository("ReclamationBundle:Reclamation")->rechercheAjax($ses);
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $result = $serializer->normalize($reclamations);
            return new JsonResponse($result);
        }
        return $this->render('ReclamationBundle:Reclamation:find-ajax.html.twig', array(
            'voitures' => $reclamations
        ));
    }

    public function DeleteExpirationAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Reclamation = $em->getRepository('ReclamationBundle:Reclamation')->find($id);
        $x=$Reclamation->getDateDecouverte();
        var_dump($x);
        $reclamations = $this->getDoctrine()->getRepository('ReclamationBundle:Reclamation')
            ->DeleteApresExpiration($x);

       return  var_dump($reclamations);


    }

}
