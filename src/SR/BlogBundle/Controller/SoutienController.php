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
class SoutienController extends BlogController
{
    /**
     * Permet d'accéder à la page devenir membre
     *
     * @Route("/devenir-membre", name="sr_blog_devenir_membre" )
     */
    public function devenirMembreAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Devenir membre', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Soutien:devenir-membre.html.twig');
    }

    /**
     * Permet d'accéder à la page contact
     *
     * @Route("/contact/{type}", name="sr_blog_contact", requirements={"type" = "\d+"}, defaults={"type" = 1} )
     */
    public function contactAction(Request $request, $type)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Contact', $this->get("router")->generate($request->get('_route')));

        $message = null;
        switch ($type) {
            case 1:
                $message = "Cette section vous permet de nous soutenir en nous envoyant des messages";
                break;
            case 2:
                $message = "Si vous souhaitez devenir membre d'AHUEFA, contacter nous avec ce formulaire.";
                break;
            case 3:
                $message = "Cette section vous permet de nous contacter pour prendre rendez-vous (par téléphone ou mail)
                           ou nous demander plus d'informations (par téléphone ou mail)";
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
        if ($message) {
            $this->get('mailer')->send($message);
        }

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

        if(stristr($messageMail, 'http') === TRUE) {
            return false;
        }

        $contenu_mail = 'Nom: '.$name."\n".'Prénom: '.$firstname."\n".'Email: '.$email."\n".'Téléphone: '.$phone."\n".$messageMail;



        $message = \Swift_Message::newInstance()
            ->setSubject($typeContact)
            ->setFrom('contact@ahuefa.org')
            ->setTo('ahuefai.france@gmail.com')
            ->setBody($contenu_mail);

        return $message;
    }

    /**
     * Permet d'accéder à la page de confirmation
     *
     * @Route("/contact/confirmation", name="sr_blog_contact_confirmation" )
     */
    public function confirmationAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Contact', $this->get("router")->generate('sr_blog_contact'));
        $breadcrumbs->addItem('Confirmation', $this->get("router")->generate($request->get('_route')));


        return $this->render('SRBlogBundle:Soutien:confirmation.html.twig');
    }
}



