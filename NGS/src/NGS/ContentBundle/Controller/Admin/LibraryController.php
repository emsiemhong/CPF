<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\Library;
use NGS\ContentBundle\Form\LibraryType;

class LibraryController extends Controller
{
	public function indexAction()
    {
        $libraries = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Library')
            ->findBy(array(), array('created' => 'desc'));

        return $this->render('NGSContentBundle::Admin/Library/list.html.twig', array(
            'libraries' => $libraries
        ));
    }

    public function deleteAction(Library $library)
    {
        $em = $this->getDoctrine()->getManager();
        $library->removeUpload();
        $library->removeFileUpload();
        $em->remove($library);
        $em->flush();

        $this->addFlash(
            'success',
            $this->get('translator')->trans('delete.message.success')
        );

        return $this->redirectToRoute('admin_library');
    }

    public function newAction(Request $request)
    {
        $library = new Library();
        $form = $this->createCreateForm($library);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($library);
            $em->persist($library);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('new.message.success')
            );

            return $this->redirectToRoute('admin_library');
        }

        return $this->render('NGSContentBundle::Admin/Library/new.html.twig', array(
            'library' => $library,
            'form' => $form->createView()
        ));
    }

    private function createCreateForm(Library $library)
    {
        $form = $this->createForm(
            new LibraryType($this->get('translator')),
            $library,
            array(
                'action' => $this->generateUrl('admin_library_new'),
                'method' => 'POST'
            )
        );

        return $form;
    }

    /**
     * Displays a form to edit an existing entity.
     *
     */
    public function editAction(Library $library, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createEditForm($library);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($library);
            $em->persist($library);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('edit.message.success')
            );

            return $this->redirectToRoute('admin_library');
        }

        return $this->render('NGSContentBundle::Admin/library/edit.html.twig', array(
            'library' => $library,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a library entity.
    *
    * @param library $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Library $library)
    {
        $form = $this->createForm(
            new LibraryType($this->get('translator'), 'edit.main'),
            $library,
            array(
                'action' => $this->generateUrl(
                    'admin_library_edit',
                    array('id' => $library->getId())
                ),
                'method' => 'POST',
            )
        );

        return $form;
    }

    private function beforePersist($library)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $library->setPostedBy($user);
        $library->setCreated(new \DateTime());

        $library->preUpload();
        $library->upload();
        $library->preUploadFile();
        $library->uploadFile();
    }
}
