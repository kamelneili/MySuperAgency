<?php
namespace App\Notification ;
use App\Entity\Contact;

class ContactNotification
{
    private $mailer;
    private $renderer;
    public function __construct(\Swift_Mailer $mailer, \Twig\Environment $renderer) 
    {
        $this->mailer=$mailer;
        $this->renderer=$renderer;
    }


    public function notify(Contact $contact)
    {
        $message = (new \Swift_Message('agence:'.$contact->getProperty()->getTitle()))
        ->setFrom('noreply@agence.com')
        ->setReplyTo($contact->getEmail())
        ->setTo('contact@agence.com')
        ->setBody(
            $this->renderer->render(
                'emails/contact.html.twig',[
                    'contact'=>$contact ]),'text/html');
               
           return $this->mailer->send($message);

    }
}


