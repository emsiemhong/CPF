<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\Announcement;

class AnnouncementController extends Controller
{
    public function indexAction()
    {
        $announcements = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Announcement')
            ->findBy(array(), array('date' => 'desc'));

        return $this->render('NGSContentBundle::announcements.html.twig', array(
            'announcements' => $announcements,
            'page' => 'announcement'
        ));
    }

    public function announcementAction(Announcement $announcement)
    {
        return $this->render('NGSContentBundle::announcement.html.twig', array(
            'announcement' => $announcement,
            'page' => 'announcement'
        ));
    }
}