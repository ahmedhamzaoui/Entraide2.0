<?php

namespace ReclamationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ReclamationBundle:Default:index.html.twig');
    }

    public function indexadminAction()
    {
        return $this->render('ReclamationBundle:Default:indexadmin.html.twig');
    }
}
