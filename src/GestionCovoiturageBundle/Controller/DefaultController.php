<?php

namespace GestionCovoiturageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GestionCovoiturageBundle:Default:index.html.twig');
    }
}
