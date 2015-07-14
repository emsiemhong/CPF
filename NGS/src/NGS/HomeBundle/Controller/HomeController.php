<?php

namespace NGS\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $abouts = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllAboutType();

        $services = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllServiceType();

        $events = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Event')
            ->findAllAvailable();

        return $this->render('NGSHomeBundle::home.html.twig', array(
            'services' => $services,
            'events' => $events,
            'abouts' => $abouts,
            'page' => 'home'
        ));
    }

    public function menuAction()
    {
        $abouts = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllAboutType();

        $services = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllServiceType();

        return $this->render('NGSHomeBundle::menu.html.twig', array(
            'services' => $services,
            'abouts' => $abouts
        ));
    }

    public function aboutBlockAction()
    {
        $abouts = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllAboutType();

        return $this->render('NGSHomeBundle::about_block.html.twig', array(
            'abouts' => $abouts,
            'page' => 'about'
        ));
    }

    public function serviceBlockAction()
    {
        $services = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllServiceType();

        return $this->render('NGSHomeBundle::service_block.html.twig', array(
            'services' => $services,
            'page' => 'service'
        ));
    }
}
