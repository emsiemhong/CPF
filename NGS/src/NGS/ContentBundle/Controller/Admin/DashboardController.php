<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->redirectToRoute('admin_article');
        // return $this->render('NGSContentBundle::Admin/dashboard.html.twig');
    }
}
