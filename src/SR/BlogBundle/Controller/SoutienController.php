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
     * Permet d'accéder à la page don
     *
     * @Route("/don", name="sr_blog_soutien_don" )
     */
    public function donAction()
    {
        return $this->render('SRBlogBundle:Soutien:don.html.twig');
    }

    /**
     * Permet d'accéder à la page contact
     *
     * @Route("/contact/{type}", name="sr_blog_contact", requirements={"type" = "\d+"}, defaults={"type" = 1} )
     */
    public function contactAction($type)
    {   $message = null;
        switch ($type) {
            case 1:
                $message = "Cette section vous permet de nous soutenir en nous envoyant des messages";
                break;
            case 2:
                $message = "Si vous souhaitez devenir membre d'AHEUFA, contacter nous avec ce formulaire";
                break;
            case 3:
                $message = "Cette section vous permet de nous contacter pour prendre rendez-vous (par téléphone ou mail)
                           ou nous demander plus d'information (par téléphone ou mail)";
                break;
        }

        return $this->render('SRBlogBundle:Soutien:contact.html.twig', [
            'type'    => $type,
            'message' => $message,
        ]);
    }

    /**
     * Permet d'accéder d'envoyer un mail
     *
     * @Route("/contact/send/{typeContact}", name="sr_blog_contact_send" )
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
    public function sendEmail($typeContact,$request)  //TODO: L'envoie de mail ne fonctionne pas. Pas demail envoyé depuis la boite mail.
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
     * @Route("/contact/confirmation", name="sr_blog_contact_confirmation" )
     */
    public function confirmationAction()
    {
        return $this->render('SRBlogBundle:Soutien:confirmation.html.twig');
    }
}



