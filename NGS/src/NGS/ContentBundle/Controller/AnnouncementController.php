<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\Announcement;

class AnnouncementController extends Controller
{
    public function announcementAction(Announcement $announcement)
    {
        return $this->render('NGSContentBundle::announcement.html.twig', array(
            'announcement' => $announcement,
            'page' => 'announcement'
        ));
    }
}