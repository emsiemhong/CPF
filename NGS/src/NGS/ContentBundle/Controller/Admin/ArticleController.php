<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Form\ArticleType;
use NGS\ContentBundle\Entity\Article;

class ArticleController extends Controller
{
    public function indexAction()
    {
        $articles = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Article')
            ->findAll(array(), array('created' => 'desc'));

        return $this->render('NGSContentBundle::Admin/Article/list.html.twig', array(
            'articles' => $articles
        ));
    }

    public function deleteAction(Article $article)
    {
        $em = $this->getDoctrine()->getManager();
        $article->removeUpload();
        $em->remove($article);
        $em->flush();

        $this->addFlash(
            'success',
            $this->get('translator')->trans('delete.message.success')
        );

        return $this->redirectToRoute('admin_article');
    }

    /**
     * Displays a form to edit an existing entity.
     *
     */
    public function editAction(Article $article, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createEditForm($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($article);
            $em->persist($article);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('edit.message.success')
            );

            return $this->redirectToRoute('admin_article');
        }

        return $this->render('NGSContentBundle::Admin/Article/edit.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a article entity.
    *
    * @param Article $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Article $article)
    {
        $form = $this->createForm(
            new ArticleType($this->get('translator'), 'edit.main'),
            $article,
            array(
                'action' => $this->generateUrl(
                    'admin_article_edit',
                    array('id' => $article->getId())
                ),
                'method' => 'POST',
            )
        );

        return $form;
    }

    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createCreateForm($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($article);
            $em->persist($article);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('new.message.success')
            );

            return $this->redirectToRoute('admin_article');
        }

        return $this->render('NGSContentBundle::Admin/Article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

    private function createCreateForm(Article $article)
    {
        $form = $this->createForm(
            new ArticleType($this->get('translator')),
            $article,
            array(
                'action' => $this->generateUrl('admin_article_new'),
                'method' => 'POST'
            )
        );

        return $form;
    }

    private function beforePersist($article)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $article->setPostedBy($user);
        $article->setCreated(new \DateTime());
        $article->preUpload();
        $article->upload();
    }
}
