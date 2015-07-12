<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Form\AnnouncementType;
use NGS\ContentBundle\Entity\Announcement;

class AnnouncementController extends Controller
{
    public function indexAction()
    {
        $announcements = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Announcement')
            ->findBy(array(), array('created' => 'desc'));

        return $this->render('NGSContentBundle::Admin/Announcement/list.html.twig', array(
            'announcements' => $announcements
        ));
    }

    public function deleteAction(Announcement $announcement)
    {
        $em = $this->getDoctrine()->getManager();
        $this->removeUpload();
        $em->remove($announcement);
        $em->flush();

        $this->addFlash(
            'success',
            $this->get('translator')->trans('delete.message.success')
        );

        return $this->redirectToRoute('admin_announcement');
    }

    public function newAction(Request $request)
    {
        $announcement = new Announcement();
        $form = $this->createCreateForm($announcement);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($announcement);
            $em->persist($announcement);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('new.message.success')
            );

            return $this->redirectToRoute('admin_announcement');
        }

        return $this->render('NGSContentBundle::Admin/Announcement/new.html.twig', array(
            'announcement' => $announcement,
            'form' => $form->createView()
        ));
    }

    private function createCreateForm(Announcement $announcement)
    {
        $form = $this->createForm(
            new AnnouncementType($this->get('translator')),
            $announcement,
            array(
                'action' => $this->generateUrl('admin_announcement_new'),
                'method' => 'POST'
            )
        );

        return $form;
    }

    /**
     * Displays a form to edit an existing entity.
     *
     */
    public function editAction(Announcement $announcement, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createEditForm($announcement);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($announcement);
            $em->persist($announcement);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('edit.message.success')
            );

            return $this->redirectToRoute('admin_announcement');
        }

        return $this->render('NGSContentBundle::Admin/Announcement/edit.html.twig', array(
            'announcement' => $announcement,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a announcement entity.
    *
    * @param Announcement $announcement The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Announcement $announcement)
    {
        $form = $this->createForm(
            new AnnouncementType($this->get('translator'), 'edit.main'),
            $announcement,
            array(
                'action' => $this->generateUrl(
                    'admin_announcement_edit',
                    array('id' => $announcement->getId())
                ),
                'method' => 'POST',
            )
        );

        return $form;
    }

    private function beforePersist($announcement)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $announcement->setPostedBy($user);
        $announcement->setCreated(new \DateTime());
        $announcement->preUpload();
        $announcement->upload();
    }
}