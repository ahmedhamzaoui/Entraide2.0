<?php

namespace RevisionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RevisionBundle:Default:index.html.twig');
    }
}
