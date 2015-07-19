<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function downloadAction($filename)
    {
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/uploads/libraries/";
        $content = file_get_contents($path.$filename);

        $response = new Response();

        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);

        return $response;
    }

    public function readAction($filename)
    {
        $request = $this->get('request');
        $path = $this->get('kernel')->getRootDir(). "/../web/uploads/libraries/";
        $content = file_get_contents($path.$filename);
        
        $response = new Response();

        $response->headers->set('Content-Type', 'mime/type');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);

        return $this->render('NGSContentBundle::read.html.twig', array(
            'filename' => $filename,
            'page' => 'library'
        ));
    }
}