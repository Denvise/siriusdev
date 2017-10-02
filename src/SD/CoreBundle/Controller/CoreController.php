<?php

namespace SD\CoreBundle\Controller;

use SD\CoreBundle\Entity\Contact;
use SD\CoreBundle\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CoreController extends Controller
{
    public function indexAction()
    {

        $datetime1 = new \DateTime('now');
        $datetime2 = new \DateTime('1991-03-31');
        $interval = $datetime1->diff($datetime2);
        $age = $interval->format('%Y%');
        return $this->render('SDCoreBundle::index.html.twig', [
            'age' => $age
        ]);
    }

    public function contactAction(Request $request)
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $name = $form['name']->getData();
            $email = $form['email']->getData();
            $subject = $form['subject']->getData();
            $message = $form['message']->getData();

            $contact->setName($name);
            $contact->setEmail($email);
            $contact->setSubject($subject);
            $contact->setMessage($message);

            $message = \Swift_Message::newInstance()

                ->setSubject($subject)
                ->setFrom('jardisindustrie@gmail.com')
                ->setTo($email)
                ->setBody($this->renderView('sendmail.html.twig', array(
                    'name' => $name,
                    'message' => $message,
                    'email' => $email,
                    'subject' => $subject)), 'text/html');
            $this->get('mailer')->send($message);
        }

        return $this->render('SDCoreBundle::contact.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
