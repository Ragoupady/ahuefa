<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SR\BlogBundle\Entity\News;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * Permet d'accéder à la page d'accueil
     *
     * @Route("/", name="sr_blog_home" )
     */
    public function indexAction()
    {
        return $this->render('SRBlogBundle:Main:index.html.twig');
    }

    /**
     * Permet d'accéder à la page d'historique
     *
     * @Route("/historique", name="sr_blog_historique" )
     */
    public function historiqueAction()
    {
        return $this->render('SRBlogBundle:Main:historique.html.twig');
    }

    /**
     * Permet d'accéder à la page d'objectif
     *
     * @Route("/objectif", name="sr_blog_objectif" )
     */
    public function objectifAction()
    {
        return $this->render('SRBlogBundle:Main:objectif.html.twig');
    }

    /**
     * Permet d'accéder à la page des actions d'ahuefa
     *
     * @Route("/actions", name="sr_blog_actions" )
     */
    public function actionsAction()
    {
        return $this->render('SRBlogBundle:Main:actions.html.twig');
    }

    /**
     * Permet d'accéder à la page des voyage culturel
     *
     * @Route("/voyage-transculturel", name="sr_blog_actions_voyage_transculturel" )
     */
    public function voyageAction()
    {
        return $this->render('SRBlogBundle:Main:voyage.html.twig');
    }

    /**
     * Permet d'accéder à la page de consultation
     *
     * @Route("/consultation", name="sr_blog_actions_consultation" )
     */
    public function consultationAction()
    {
        return $this->render('SRBlogBundle:Main:consultation.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation
     *
     * @Route("/mediation", name="sr_blog_actions_mediation" )
     */
    public function mediationAction()
    {
        return $this->render('SRBlogBundle:Main:mediation.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation définition
     *
     * @Route("/mediation-definition", name="sr_blog_actions_mediation_definition" )
     */
    public function mediationDefAction()
    {
        return $this->render('SRBlogBundle:Main:mediationDef.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation étape
     *
     * @Route("/mediation-etape", name="sr_blog_actions_mediation_etapes" )
     */
    public function mediationEtapeAction()
    {
        return $this->render('SRBlogBundle:Main:mediationEtape.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation travail
     *
     * @Route("/mediation-travail", name="sr_blog_actions_mediation_travail" )
     */
    public function mediationTravailAction()
    {
        return $this->render('SRBlogBundle:Main:mediationTravail.html.twig');
    }

    /**
     * Permet d'accéder à la page de appui professionnel
     *
     * @Route("/appui-pro", name="sr_blog_actions_appui_pro" )
     */
    public function appuiProAction()
    {
        return $this->render('SRBlogBundle:Main:appuiPro.html.twig');
    }

    /**
     * Permet d'accéder à la page de soutien
     *
     * @Route("/soutien", name="sr_blog_actions_soutien" )
     */
    public function soutienAction()
    {
        return $this->render('SRBlogBundle:Main:soutien.html.twig');
    }

    /**
     * Permet d'accéder à la page équipe
     *
     * @Route("/equipe", name="sr_blog_equipe" )
     */
    public function equipeAction()
    {
        return $this->render('SRBlogBundle:Main:equipe.html.twig');
    }

    /**
     * Permet d'accéder à la page partenaire
     *
     * @Route("/partenaire", name="sr_blog_partenaire" )
     */
    public function partenaireAction()
    {
        return $this->render('SRBlogBundle:Main:partenaire.html.twig');
    }

    /**
     * Permet d'accéder à la page seminaire et formation
     *
     * @Route("/seminaire-formation", name="sr_blog_seminaire_formation" )
     */
    public function seminaireFormationAction()
    {
        return $this->render('SRBlogBundle:Main:seminaire_formation.html.twig');
    }

    /**
     * Permet d'accéder à la page groupes de parole
     *
     * @Route("/groupes-de-parole", name="sr_blog_groupes_parole" )
     */
    public function groupesDeParoleAction()
    {
        return $this->render('SRBlogBundle:Main:groupes_de_parole.html.twig');
    }

    /**
     * Permet d'accéder à la page visite mediatisee
     *
     * @Route("/visite-mediatisee", name="sr_blog_actions_visite_mediatisee" )
     */
    public function visiteMediatiseeAction()
    {
        return $this->render('SRBlogBundle:Main:visite_mediatisee.html.twig');
    }


    /**
     * Permet de rechercher du contenu à l'aide d'une chaine de caractère. La recheche permet de retourner les articles et/ou les events
     *
     * @Route("/search", name="sr_blog_search" )
     */
    public function searchAction(Request $request)
    {
        $content = $request->request->get('content');
        //recherche des article contenant $content dans le titre ou le contenu de l'article
        $listNews = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->getNewsSearch($content); 

        //recherche des événement contenant $content dans le titre ou le contenu de l'événement
        $listEvents = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Event')->getEventsSearch($content);

        return $this->render('SRBlogBundle:Main:searchResult.html.twig', [
            'listNews' => $listNews,
            'listEvents' => $listEvents,
            'content' => $content
        ]);
    }
}



