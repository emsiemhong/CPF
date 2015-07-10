<?php

namespace NGS\HomeBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $services = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllServiceType();

        $events = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Event')
            ->findAll();

        return $this->render('NGSHomeBundle::home.html.twig', array(
            'services' => $services,
            'events' => $events
        ));
    }
}
