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
        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $form->get('name')->getData(); 
            $email = $form->get('email')->getData(); 
            $subject = $form->get('subject')->getData(); 
            $body = $form->get('body')->getData(); 

            if ($request->request->get('submit')) {
                $message = \Swift_Message::newInstance()
                        ->setSubject($subject)
                        ->setFrom($email)
                        -setTo('emsiemhong@gmail.com')
                        ->setBody($body);

                $this->get('mailer')->Send($message);
                $data = "Thank you $name";
            }
        }

        return $this->render('NGSContentBundle::contact.html.twig', array(
            'form' => $form->createView(),
            'page' => 'contact'
        ));
    }
}
