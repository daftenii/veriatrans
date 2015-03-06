<?php

namespace Veriatrans\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VeriatransMainBundle:Default:index.html.twig', array());
    }
}
