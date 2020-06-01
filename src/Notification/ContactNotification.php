<?php
namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;


class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct( \Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }
    public function notify(Contact $contact) {

        $message = (new \Swift_Message('Annonce : ' . $contact->getProperty()->getTitle()))
        ->setFrom ('noreplay@voisindaccote.fr')
        ->setTo('contact@voisindaccote.fr')
        ->setReplyTo($contact->getEmail())
        ->setBody($this->rendrerer->render('emails/contact.html.twig', [
            'contact' =>$contact
        ]), 'text/hmtl');
        $this->mailer->send($message);
    }
}