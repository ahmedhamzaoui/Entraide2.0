<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Res;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Evenement controller.
 *
 */
class EvenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     */
    public function indexAction()
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user==='anon.')
        { $em = $this->getDoctrine()->getManager();
            $evenements = $em->getRepository('EvenementBundle:Evenement')->findAll();

            $club=$em->getRepository('EvenementBundle:Club')->findAll();
            return $this->render('evenement/index.html.twig', array(
                'evenements' => $evenements,
                'club'=>$club,

            ));
        }else{
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) ) {
            $em = $this->getDoctrine()->getManager();
            $evenements = $em->getRepository('EvenementBundle:Evenement')->findAll();

            $club=$em->getRepository('EvenementBundle:Club')->findAll();
            return $this->render('evenement/indexadmin.html.twig', array(
                'evenements' => $evenements,
                'club'=>$club,

            ));
        }else{
            $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository('EvenementBundle:Evenement')->findAll();
            $club=$em->getRepository('EvenementBundle:Club')->findAll();
            $part=$em->getRepository('EvenementBundle:PartClub')->findBy(array('idMembre'=>$user));
        return $this->render('evenement/index.html.twig', array(
            'evenements' => $evenements,
            'club'=>$club,
            'part'=>$part

        ));
    }}}

    /**
     * Creates a new evenement entity.
     *
     */
    public function newAction(Request $request)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $clubs = $em->getRepository('EvenementBundle:Club')->findOneBy(array('idUser'=>$user));
        if ($user==='anon.' or $clubs==null){
            return $this->redirectToRoute('homepage');
        }else{

            $evenement = new Evenement();
        $form = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $evenement->getPhoto();
            $file->move(
                $this->getParameter('event_upload'), $file->getClientOriginalName());
            $evenement->setPhoto($file->getClientOriginalName());
            $evenement->setIdUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('e_show', array('id' => $evenement->getId()));
        }

        return $this->render('evenement/new.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));
    }

    }



    /**
     * Finds and displays a evenement entity.
     *
     */
    public function showAction(Evenement $evenement)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        $deleteForm = $this->createDeleteForm($evenement);
        $em = $this->getDoctrine()->getManager();
        if ($user!=='anon.' ) {

            $res = $em->getRepository('EvenementBundle:Res')->findOneBy(array('idUser' => $user,'idE'=>$evenement->getId()));
            return $this->render('evenement/show.html.twig', array(
                'res'=>$res,
                'evenement' => $evenement,
                'delete_form' => $deleteForm->createView(),
            ));
        }else{
            $res=null;


        return $this->render('evenement/show.html.twig', array(
            'res'=>$res,
            'evenement' => $evenement,
            'delete_form' => $deleteForm->createView(),
        ));
        }
    }


    /**
     * Displays a form to edit an existing evenement entity.
     *
     */
    public function editAction(Request $request, Evenement $evenement)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $clubs = $em->getRepository('EvenementBundle:Club')->findOneBy(array('idUser'=>$user));
        if ($user==='anon.' or $evenement->getIdUser()!==$user){
            return $this->redirectToRoute('homepage');
        }else{
        $deleteForm = $this->createDeleteForm($evenement);
        $editForm = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $evenement->getPhoto();
            $file->move(
                $this->getParameter('event_upload'), $file->getClientOriginalName());
            $evenement->setPhoto($file->getClientOriginalName());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('e_show', array('id' => $evenement->getId()));
        }

        return $this->render('evenement/edit.html.twig', array(
            'evenement' => $evenement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    }

    /**
     * Deletes a evenement entity.
     *
     */
    public function deleteAction(Request $request, Evenement $evenement)
    {
        $form = $this->createDeleteForm($evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }

        return $this->redirectToRoute('e_index');
    }

    /**
     * Creates a form to delete a evenement entity.
     *
     * @param Evenement $evenement The evenement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('e_delete', array('id' => $evenement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function rechAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository('EvenementBundle:Evenement')->recherche($_GET['rech']);

        return $this->render('evenement/index.html.twig', array(
            'evenements' => $evenements,
        ));
    }
    public function resAction(Request $request, Evenement $evenement)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        $em = $this->getDoctrine()->getManager();

        $res=new Res();
        $res->setIdUser($user);
        $res->setIdE($evenement->getId());
        $evenement->setNbreDispo($evenement->getNbreDispo()-1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($evenement);
        $em->persist($res);
        $em->flush();


        return $this->redirectToRoute('e_show', array(
            'id' => $evenement->getId(),
        ));
    }
    public function listeAction(Request $request, Evenement $evenement)
    {
        $em = $this->getDoctrine()->getManager();

        $res=$em->getRepository('EvenementBundle:Res')->findBy(array('idE'=>$evenement->getId()));

        return $this->render('evenement/liste.html.twig', array(
            'evenement' => $evenement,
            'res' => $res,

        ));
    }
}
