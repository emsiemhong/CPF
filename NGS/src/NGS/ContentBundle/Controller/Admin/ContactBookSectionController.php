<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\ContactBookSection;
use NGS\ContentBundle\Form\ContactBookSectionType;

class ContactBookSectionController extends Controller
{
    public function indexAction()
    {
        $sections = $this->getDoctrine()
            ->getRepository('NGSContentBundle:ContactBookSection')
            ->findAll();

        return $this->render('NGSContentBundle::Admin/ContactBookSection/list.html.twig', array(
            'sections' => $sections
        ));
    }

    public function deleteAction(ContactBookSection $section)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($section);
        $em->flush();

        $this->addFlash(
            'success',
            $this->get('translator')->trans('delete.message.success')
        );

        return $this->redirectToRoute('admin_contactbook_section');
    }

    public function newAction(Request $request)
    {
        $section = new ContactBookSection();
        $form = $this->createCreateForm($section);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($section);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('new.message.success')
            );

            return $this->redirectToRoute('admin_contactbook_section');
        }

        return $this->render('NGSContentBundle::Admin/ContactBookSection/new.html.twig', array(
            'section' => $section,
            'form' => $form->createView()
        ));
    }

    private function createCreateForm(ContactBookSection $section)
    {
        $form = $this->createForm(
            new ContactBookSectionType($this->get('translator')),
            $section,
            array(
                'action' => $this->generateUrl('admin_contactbook_section_new'),
                'method' => 'POST'
            )
        );

        return $form;
    }

    /**
     * Displays a form to edit an existing entity.
     *
     */
    public function editAction(ContactBookSection $section, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createEditForm($section);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($section);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('edit.message.success')
            );

            return $this->redirectToRoute('admin_contactbook_section');
        }

        return $this->render('NGSContentBundle::Admin/ContactBookSection/edit.html.twig', array(
            'section' => $section,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a section
    *
    * @param ContactBookSection $section The section
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ContactBookSection $section)
    {
        $form = $this->createForm(
            new ContactBookSectionType($this->get('translator'), 'edit.main'),
            $section,
            array(
                'action' => $this->generateUrl(
                    'admin_contactbook_section_edit',
                    array('id' => $section->getId())
                ),
                'method' => 'POST',
            )
        );

        return $form;
    }
}
