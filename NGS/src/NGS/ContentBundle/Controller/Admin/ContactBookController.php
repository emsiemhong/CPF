<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\ContactBook;
use NGS\ContentBundle\Form\ContactBookType;

class ContactBookController extends Controller
{
    public function indexAction()
    {
        $contact_books = $this->getDoctrine()
            ->getRepository('NGSContentBundle:ContactBook')
            ->findAll();

        return $this->render('NGSContentBundle::Admin/ContactBook/list.html.twig', array(
            'contact_books' => $contact_books
        ));
    }

    public function deleteAction(ContactBook $contact_book)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact_book);
        $em->flush();

        $this->addFlash(
            'success',
            $this->get('translator')->trans('delete.message.success')
        );

        return $this->redirectToRoute('admin_contactbook');
    }

    public function newAction(Request $request)
    {
        $contact_book = new ContactBook();
        $form = $this->createCreateForm($contact_book);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($contact_book);
            $em->persist($contact_book);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('new.message.success')
            );

            return $this->redirectToRoute('admin_contactbook');
        }

        return $this->render('NGSContentBundle::Admin/ContactBook/new.html.twig', array(
            'contact_book' => $contact_book,
            'form' => $form->createView()
        ));
    }

    private function createCreateForm(ContactBook $contact_book)
    {
        $form = $this->createForm(
            new ContactBookType($this->get('translator')),
            $contact_book,
            array(
                'action' => $this->generateUrl('admin_contactbook_new'),
                'method' => 'POST'
            )
        );

        return $form;
    }

    /**
     * Displays a form to edit an existing entity.
     *
     */
    public function editAction(ContactBook $contact_book, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createEditForm($contact_book);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($contact_book);
            $em->persist($contact_book);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('edit.message.success')
            );

            return $this->redirectToRoute('admin_contactbook');
        }

        return $this->render('NGSContentBundle::Admin/ContactBook/edit.html.twig', array(
            'contact_book' => $contact_book,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a contact_book entity.
    *
    * @param ContactBook $contact_book The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContactBook $contact_book)
    {
        $form = $this->createForm(
            new ContactBookType($this->get('translator'), 'edit.main'),
            $contact_book,
            array(
                'action' => $this->generateUrl(
                    'admin_contactbook_edit',
                    array('id' => $contact_book->getId())
                ),
                'method' => 'POST',
            )
        );

        return $form;
    }

    private function beforePersist($contact_book)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $contact_book->setPostedBy($user);
        $contact_book->setCreated(new \DateTime());
        $contact_book->preUpload();
        $contact_book->upload();
    }
}
