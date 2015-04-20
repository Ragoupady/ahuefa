<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SoutienController extends Controller
{
    public function membreAction()
    {
        return $this->render('SRBlogBundle:Soutien:membre.html.twig');
    }

    public function donAction()
    {
        return $this->render('SRBlogBundle:Soutien:don.html.twig');
    }

    public function messageAction()
    {
        return $this->render('SRBlogBundle:Soutien:message.html.twig');
    }

    public function contactAction()
    {
        return $this->render('SRBlogBundle:Soutien:contact.html.twig');
    }

    public function contact_sendAction(Request $request, $typeContact)
    {   
       

        $message = $this->sendEmail($typeContact,$request);
        $this->get('mailer')->send($message);
        
        //on appelle la route qui va afficher le message de confirmation
        return $this->redirect($this->generateUrl('sr_blog_contact_confirmation'));

    }

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


    public function confirmationAction()
    {

        return $this->render('SRBlogBundle:Soutien:confirmation.html.twig');
    }
}



