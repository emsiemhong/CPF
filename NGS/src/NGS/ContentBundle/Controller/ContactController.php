<?php

namespace NGS\ContentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NGS\ContentBundle\Form\ContactType;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $form = $this->createForm(new ContactType($this->get('translator')));

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo('contact@example.com')
                    ->setBody(
                        $this->renderView(
                            'NGSContentBundle:contact.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('name')->getData(),
                                'message' => $form->get('message')->getData()
                            )
                        )
                    );

                $this->get('mailer')->send($message);

                $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');

                return $this->redirectToRoute('contact');
            }
        }

        return $this->render('NGSContentBundle::contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
