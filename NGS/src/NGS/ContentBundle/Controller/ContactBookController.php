<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\ContactBookSection;

class ContactBookController extends Controller
{
    public function indexAction()
    {
        $contactBooks = $this->getDoctrine()
            ->getRepository('NGSContentBundle:ContactBook')
            ->findAll();

        return $this->render('NGSContentBundle::contactBooks.html.twig', array(
            'contactBooks' => $contactBooks,
            'page' => 'contactBook'
        ));
    }

    public function listBySectionAction(ContactBookSection $section)
    {

        $contactBooks = $section->getContactBook();

        return $this->render('NGSContentBundle::contactBooks.html.twig', array(
            'contactBooks' => $contactBooks,
            'page' => 'contactBook'
        ));
    }
}