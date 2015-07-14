<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\Event;

class EventController extends Controller
{
	public function indexAction()
    {
        $events = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Event')
            ->findBy(array(), array('date' => 'desc'));

        return $this->render('NGSContentBundle::events.html.twig', array(
            'events' => $events,
            'page' => 'event'
        ));
    }

    public function eventAction(Event $event)
    {
    	return $this->render('NGSContentBundle::event.html.twig', array(
    		'event' => $event,
    		'page' => 'event'
    	));
    }
}