<?php

namespace NGS\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
         // The date bigger than current date is available
        $events = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Event')
            ->findAllAvailable();

        $announcements = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Announcement')
            ->findAllAvailable();

        return $this->render('NGSHomeBundle::home.html.twig', array(
            'events' => $events,
            'announcements' => $announcements,
            'page' => 'home'
        ));
    }

    public function sidebarFirstAction()
    {
        $sections = $this->getDoctrine()
            ->getRepository('NGSContentBundle:ContactBookSection')
            ->findAllAvailable();

        // The date bigger than current date is available
        $events = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Event')
            ->findAllAvailable();

        $announcements = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Announcement')
            ->findAllAvailable();

        return $this->render('NGSHomeBundle::sidebar_first.html.twig', array(
            'events' => $events,
            'sections' => $sections,
            'announcements' => $announcements,
            'page' => 'home'
        ));
    }

    public function menuAction($page)
    {
        $abouts = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllAboutType();

        $services = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllServiceType();

        return $this->render('NGSHomeBundle::menu.html.twig', array(
            'services' => $services,
            'abouts' => $abouts,
            'page' => $page
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
