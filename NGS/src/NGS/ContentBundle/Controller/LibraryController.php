<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\Library;

class LibraryController extends Controller
{
    public function indexAction()
    {
        $libraries = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Library')
            ->findAll();

        return $this->render('NGSContentBundle::libraries.html.twig', array(
            'libraries' => $libraries,
            'page' => 'library'
        ));
    }
}