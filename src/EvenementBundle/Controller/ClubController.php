<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Club;
use EvenementBundle\Entity\PartClub;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Club controller.
 *
 */
class ClubController extends Controller
{
    /**
     * Lists all club entities.
     *
     */
    public function indexAction()
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) ) {

            $em = $this->getDoctrine()->getManager();

        $clubs = $em->getRepository('EvenementBundle:Club')->findAll();

        return $this->render('club/index.html.twig', array(
            'clubs' => $clubs,
        ));}else{
            $em = $this->getDoctrine()->getManager();

            $clubs = $em->getRepository('EvenementBundle:Club')->findAll();

            return $this->render('club/indexuser.html.twig', array(
                'clubs' => $clubs,
            ));
        }
    }

    /**
     * Creates a new club entity.
     *
     */
    public function newAction(Request $request)
    {
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())){
        $club = new Club();
        $form = $this->createForm('EvenementBundle\Form\ClubType', $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $club->getPhoto();
            $file->move(
                $this->getParameter('club_upload'), $file->getClientOriginalName());
            $club->setPhoto($file->getClientOriginalName());
            $club->setRole("Responsable");
            $em = $this->getDoctrine()->getManager();
            $em->persist($club);
            $em->flush();

            return $this->redirectToRoute('club_show', array('idclub' => $club->getIdclub()));
        }

        return $this->render('club/new.html.twig', array(
            'club' => $club,
            'form' => $form->createView(),
        ));}
        else{
            return $this->redirectToRoute('club_index');
        }
    }

    /**
     * Finds and displays a club entity.
     *
     */
    public function showAction(Club $club)
    {
        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {

            $em = $this->getDoctrine()->getManager();
            $evenements=$em->getRepository('EvenementBundle:Evenement')->findBy(array('idUser'=>$club->getIdUser()));
            $membres=$em->getRepository('EvenementBundle:PartClub')->findBy(array('idClub'=>$club->getIdclub()));

            global $kernel;
            $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

            $deleteForm = $this->createDeleteForm($club);
            $part = $em->getRepository('EvenementBundle:PartClub')->findOneBy(array('idMembre' => $user->getId(), 'idClub' => $club->getIdclub()));
            return $this->render('club/show.html.twig', array(
                'club' => $club,
                'evenements'=>$evenements,
                'membre'=>$membres,
                'delete_form' => $deleteForm->createView(),
                'part' => $part
            ));
        }else{
            $em = $this->getDoctrine()->getManager();


            global $kernel;
            $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
            $evenements=$em->getRepository('EvenementBundle:Evenement')->findBy(array('idUser'=>$club->getIdUser()));
            $membres=$em->getRepository('EvenementBundle:PartClub')->findBy(array('idClub'=>$club->getIdclub()));

            $deleteForm = $this->createDeleteForm($club);
            $part=$em->getRepository('EvenementBundle:PartClub')->findOneBy(array('idMembre'=>$user->getId(),'idClub'=>$club->getIdclub()));
            return $this->render('club/showuser.html.twig', array(
                'club' => $club,
                'evenements'=>$evenements,
                'membre'=>$membres,
                'delete_form' => $deleteForm->createView(),
                'part'=>$part
            ));
        }
    }

    /**
     * Displays a form to edit an existing club entity.
     *
     */
    public function editAction(Request $request, Club $club)
    {
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();

        if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles()) || $club->getIdUser()==$user) {

            $deleteForm = $this->createDeleteForm($club);
            $editForm = $this->createForm('EvenementBundle\Form\ClubType', $club);
            $editForm->handleRequest($request);

            if ($editForm->isSubmitted() && $editForm->isValid()) {
                /**
                 * @var UploadedFile $file
                 */
                $file = $club->getPhoto();
                $file->move(
                    $this->getParameter('club_upload'), $file->getClientOriginalName());
                $club->setPhoto($file->getClientOriginalName());

                $club->setRole("Responsable");

                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('club_show', array('idclub' => $club->getIdclub()));
            }

            return $this->render('club/edit.html.twig', array(
                'club' => $club,
                'edit_form' => $editForm->createView(),
                'delete_form' => $deleteForm->createView(),
            ));
        }    else{
        return $this->redirectToRoute('club_index');
    }
    }

    /**
     * Deletes a club entity.
     *
     */
    public function deleteAction(Request $request, Club $club)
    {   if (in_array('ROLE_SUPER_ADMIN', $this->getUser()->getRoles())) {

        $form = $this->createDeleteForm($club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($club);
            $em->flush();
        }

        return $this->redirectToRoute('club_index');
    }    else{
        return $this->redirectToRoute('club_index');
    }
    }

    /**
     * Creates a form to delete a club entity.
     *
     * @param Club $club The club entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Club $club)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('club_delete', array('idclub' => $club->getIdclub())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a new club entity.
     *
     */
    public function partAction(Request $request,$idClub)
    {
        $em = $this->getDoctrine()->getManager();
        global $kernel;
        $user = $kernel->getContainer()->get('security.token_storage')->getToken()->getUser();
        if ($user!=='anon.'){
        $club=$em->getRepository('EvenementBundle:Club')->find($idClub);
        var_dump($user->getId());
        var_dump($club->getIdClub());
        $part=$em->getRepository('EvenementBundle:PartClub')->findOneBy(array('idClub'=>$club->getIdClub(),'idMembre'=>$user->getId()));
        if ($part===null){
            $part=new PartClub();
            $part->setIdMembre($user->getId());
            $part->setIdClub($idClub);

                $em = $this->getDoctrine()->getManager();
                $em->persist($part);
                $em->flush();

                return $this->redirectToRoute('club_show', array('idclub' => $club->getIdclub()));
            }


        else{
            return $this->redirectToRoute('club_index');
        }
        }else{
            return $this->redirectToRoute('homepage');
        }
    }
}
