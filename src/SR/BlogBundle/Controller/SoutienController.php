<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}



