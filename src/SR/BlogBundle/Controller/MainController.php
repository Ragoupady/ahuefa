<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SR\BlogBundle\Entity\News;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('SRBlogBundle:Main:index.html.twig');
    }


    public function historiqueAction()
    {
        return $this->render('SRBlogBundle:Main:historique.html.twig');
    }

    public function objectifAction()
    {
        return $this->render('SRBlogBundle:Main:objectif.html.twig');
    }

    public function actionsAction()
    {
        return $this->render('SRBlogBundle:Main:actions.html.twig');
    }

    public function voyageAction()
    {
        return $this->render('SRBlogBundle:Main:voyage.html.twig');
    }

    public function consultationAction()
    {
        return $this->render('SRBlogBundle:Main:consultation.html.twig');
    }

    public function mediationAction()
    {
        return $this->render('SRBlogBundle:Main:mediation.html.twig');
    }

    public function mediationDefAction()
    {
        return $this->render('SRBlogBundle:Main:mediationDef.html.twig');
    }

    public function mediationEtapeAction()
    {
        return $this->render('SRBlogBundle:Main:mediationEtape.html.twig');
    }

    public function mediationTravailAction()
    {
        return $this->render('SRBlogBundle:Main:mediationTravail.html.twig');
    }


    public function appuiProAction()
    {
        return $this->render('SRBlogBundle:Main:appuiPro.html.twig');
    }


    public function soutienAction()
    {
        return $this->render('SRBlogBundle:Main:soutien.html.twig');
    }

    public function equipeAction()
    {
        return $this->render('SRBlogBundle:Main:equipe.html.twig');
    }

    public function partenaireAction()
    {
        return $this->render('SRBlogBundle:Main:partenaire.html.twig');
    }

    public function searchAction(Request $request)
    {
        $content = $request->request->get('content');
        //recherche des article contenant $content dans le titre ou le contenu de l'article
        $listNews = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->getNewsSearch($content); 

        //recherche des événement contenant $content dans le titre ou le contenu de l'événement
        $listEvents = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Event')->getEventsSearch($content);
        

        return $this->render('SRBlogBundle:Main:searchResult.html.twig', array('listNews' => $listNews,
                                                                       'listEvents' => $listEvents,
                                                                       'content' => $content
                                                                       ));

    }


}



