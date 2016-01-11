<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * SoutienController : Ce controller permet de retourner les pages lié aux soutiens
 *
 * @Route("/soutien")
 */
class SoutienController extends Controller
{
    /**
     * Permet d'accéder à la page membre
     *
     * @Route("/membre", name="membre" )
     */
    public function membreAction()
    {
        return $this->render('SRBlogBundle:Soutien:membre.html.twig');
    }

    /**
     * Permet d'accéder à la page don
     *
     * @Route("/don", name="don" )
     */
    public function donAction()
    {
        return $this->render('SRBlogBundle:Soutien:don.html.twig');
    }

    /**
     * Permet d'accéder à la page message
     *
     * @Route("/message", name="message" )
     */
    public function messageAction()
    {
        return $this->render('SRBlogBundle:Soutien:message.html.twig');
    }

    /**
     * Permet d'accéder à la page contact
     *
     * @Route("/contact", name="contact" )
     */
    public function contactAction()
    {
        return $this->render('SRBlogBundle:Soutien:contact.html.twig');
    }

    /**
     * Permet d'accéder d'envoyer un mail
     *
     * @Route("/mail-send", name="mail_send" )
     */
    public function contactSendAction(Request $request, $typeContact)
    {
        $message = $this->sendEmail($typeContact,$request);
        $this->get('mailer')->send($message);
        
        //on appelle la route qui va afficher le message de confirmation
        return $this->redirect($this->generateUrl('sr_blog_contact_confirmation'));
    }

    /**
     * Permet d'accéder d'envoyer un mail
     *
     * @Route("/mail", name="mail" )
     */
    public function sendEmail($typeContact,$request)
    {
        $name= $request->request->get('name');
        $firstname= $request->request->get('firstname');
        $email= $request->request->get('email');
        $phone= $request->request->get('phone');
        $messageMail= $request->request->get('message');

        $contenu_mail = 'Nom: '.$name."\n".'Prénom: '.$firstname."\n".'Email: '.$email."\n".'Téléphone: '.$phone."\n".$messageMail;

        $message = \Swift_Message::newInstance()
            ->setSubject($typeContact)
            ->setFrom('ragou.dev@gmail.com')
            ->setTo('sagadevin.ragoupady@gmail.com')
            ->setBody($contenu_mail);

        return $message;
    }

    /**
     * Permet d'accéder à la page de confirmation
     *
     * @Route("/confrmation", name="confirmation" )
     */
    public function confirmationAction()
    {
        return $this->render('SRBlogBundle:Soutien:confirmation.html.twig');
    }
}



