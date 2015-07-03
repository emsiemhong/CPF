<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
    public function indexAction()
    {
        return $this->render('NGSContentBundle::About/about.html.twig');
    }
}
