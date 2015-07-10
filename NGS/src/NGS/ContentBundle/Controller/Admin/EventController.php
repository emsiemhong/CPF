<?php

namespace NGS\ContentBundle\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Entity\Event;
use NGS\ContentBundle\Form\EventType;

class EventController extends Controller
{
	public function indexAction()
    {
        $events = $this->getDoctrine()
            ->getRepository('NGSContentBundle:Event')
            ->findAll();

        return $this->render('NGSContentBundle::Admin/Event/list.html.twig', array(
            'events' => $events
        ));
    }

    public function deleteAction(Event $event)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($event);
        $em->flush();

        $this->addFlash(
            'success',
            $this->get('translator')->trans('delete.message.success')
        );

        return $this->redirectToRoute('admin_event');
    }

    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createCreateForm($event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($event);
            $em->persist($event);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('new.message.success')
            );

            return $this->redirectToRoute('admin_event');
        }

        return $this->render('NGSContentBundle::Admin/Event/new.html.twig', array(
            'event' => $event,
            'form' => $form->createView()
        ));
    }

    private function createCreateForm(Event $event)
    {
        $form = $this->createForm(
            new EventType($this->get('translator')),
            $event,
            array(
                'action' => $this->generateUrl('admin_event_new'),
                'method' => 'POST'
            )
        );

        return $form;
    }

    /**
     * Displays a form to edit an existing entity.
     *
     */
    public function editAction(Event $event, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createEditForm($event);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->beforePersist($event);
            $em->persist($event);
            $em->flush();
            $this->addFlash(
                'success',
                $this->get('translator')->trans('edit.message.success')
            );

            return $this->redirectToRoute('admin_event');
        }

        return $this->render('NGSContentBundle::Admin/Event/edit.html.twig', array(
            'event' => $event,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a event entity.
    *
    * @param Event $event The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Event $event)
    {
        $form = $this->createForm(
            new EventType($this->get('translator'), 'edit.main'),
            $event,
            array(
                'action' => $this->generateUrl(
                    'admin_event_edit',
                    array('id' => $event->getId())
                ),
                'method' => 'POST',
            )
        );

        return $form;
    }

    private function beforePersist($event)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $event->setPostedBy($user);
        $event->setCreated(new \DateTime());
        $event->preUpload();
        $event->upload();
    }
}
