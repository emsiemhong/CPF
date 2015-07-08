<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Form\ArticlesType;
use NGS\ContentBundle\Entity\Articles;

class ArticlesController extends Controller
{
    public function indexAction()
    {
        $articles = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Articles')
            ->findAll();

        return $this->render('NGSContentBundle::Admin/Articles/list.html.twig', array(
            'articles' => $articles
        ));
    }

    public function deleteAction(Articles $article)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        
        return $this->redirectToRoute('admin_dashboard');
    }

    public function newAction(Request $request)
    {
        $article = new Articles();
        $form = $this->createCreateForm($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->uploadPicture($article);
            $em->persist($article);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('new.message.success')
            );

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('NGSContentBundle::Admin/Articles/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

    private function createCreateForm(Articles $article)
    {
        $form = $this->createForm(
            new ArticlesType($this->get('translator')),
            $article,
            array(
                'action' => $this->generateUrl('admin_articles_new'),
                'method' => 'POST'
            )
        );

        return $form;
    }

    private function uploadPicture(Articles $article)
    {
        $article->preUpload();
        $article->upload();
    }
}
