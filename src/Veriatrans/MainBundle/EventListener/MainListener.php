<?php

namespace Veriatrans\MainBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Veriatrans\MainBundle\Entity\Event;

class MainListener
{
    protected $em;
    protected $twig;
    protected $eventCount = 0;
    public function __construct($twig,$doctrine)
    {
        $this->em = $doctrine->getManager();
        $this->twig = $twig;
        $res = $this->em->getRepository('VeriatransMainBundle:Event')->findBy(array('isViewed'=>false));
        $this->eventCount = count($res);
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $this->twig->addGlobal('event', $this->eventCount);
    }
}