<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\Article;

class ArticleController extends Controller
{
    public function aboutsAction(Request $request)
    {
        $abouts = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllAboutType();

        return $this->render('NGSContentBundle::abouts.html.twig', array(
            'abouts' => $abouts,
            'page' => 'about'
        ));
    }

    public function servicesAction()
    {
        $services = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAllServiceType();

        return $this->render('NGSContentBundle::services.html.twig', array(
            'services' => $services,
            'page' => 'service'
        ));
    }

    public function aboutAction(Article $article)
    {
        return $this->render('NGSContentBundle::article.html.twig', array(
            'article' => $article,
            'page' => 'about'
        ));
    }

    public function serviceAction(Article $article)
    {
        return $this->render('NGSContentBundle::article.html.twig', array(
            'article' => $article,
            'page' => 'service'
        ));
    }
}