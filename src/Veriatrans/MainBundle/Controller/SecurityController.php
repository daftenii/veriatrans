<?php

namespace Veriatrans\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function indexAction()
    {
        return $this->redirect( $this->generateUrl( 'login' ) );
    }

    /**
     * @Route("/login", name="_login")
     * @Route("/login_check", name="_login_check")
     * @Template("::login.html.twig")
     */
    public function loginAction()
    {
        $request = $this->get('request');
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('homepage'));
        }
        return array(
            'login' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
        );
//        return $this->render('::login.html.twig', array());
    }
    /**
     * @Route("/lout", name="_logout")
     */
    public function logoutAction()
    {

    }
}
