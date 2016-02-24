<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SR\BlogBundle\Entity\News;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends BlogController
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
    public function historiqueAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Historique', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:historique.html.twig');
    }

    /**
     * Permet d'accéder à la page d'objectif
     *
     * @Route("/objectif", name="sr_blog_objectif" )
     */
    public function objectifAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Objectif', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:objectif.html.twig');
    }

    /**
     * Permet d'accéder à la page des actions d'ahuefa
     *
     * @Route("/actions", name="sr_blog_actions" )
     */
    public function actionsAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Actions', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:actions.html.twig');
    }

    /**
     * Permet d'accéder à la page des voyage culturel
     *
     * @Route("/voyage-transculturel", name="sr_blog_actions_voyage_transculturel" )
     */
    public function voyageAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Voyage transculturel', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:voyage.html.twig');
    }

    /**
     * Permet d'accéder à la page de consultation
     *
     * @Route("/consultation", name="sr_blog_actions_consultation" )
     */
    public function consultationAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Consultation', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:consultation.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation
     *
     * @Route("/mediation", name="sr_blog_actions_mediation" )
     */
    public function mediationAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Médiation', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:mediation.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation définition
     *
     * @Route("/mediation-definition", name="sr_blog_actions_mediation_definition" )
     */
    public function mediationDefAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Médiation', $this->get("router")->generate('sr_blog_actions_mediation'));
        $breadcrumbs->addItem('Définition', $this->get("router")->generate($request->get('_route')));


        return $this->render('SRBlogBundle:Main:mediationDef.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation étape
     *
     * @Route("/mediation-etape", name="sr_blog_actions_mediation_etapes" )
     */
    public function mediationEtapeAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Médiation', $this->get("router")->generate('sr_blog_actions_mediation'));
        $breadcrumbs->addItem('Etape', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:mediationEtape.html.twig');
    }

    /**
     * Permet d'accéder à la page de médiation travail
     *
     * @Route("/mediation-travail", name="sr_blog_actions_mediation_travail" )
     */
    public function mediationTravailAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Médiation', $this->get("router")->generate('sr_blog_actions_mediation'));
        $breadcrumbs->addItem('Travail', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:mediationTravail.html.twig');
    }

    /**
     * Permet d'accéder à la page de appui professionnel
     *
     * @Route("/appui-pro", name="sr_blog_actions_appui_pro" )
     */
    public function appuiProAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Appui professionnel', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:appuiPro.html.twig');
    }

    /**
     * Permet d'accéder à la page de soutien
     *
     * @Route("/soutien", name="sr_blog_actions_soutien" )
     */
    public function soutienAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Soutien', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:soutien.html.twig');
    }

    /**
     * Permet d'accéder à la page équipe
     *
     * @Route("/equipe", name="sr_blog_equipe" )
     */
    public function equipeAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Equipe', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:equipe.html.twig');
    }

    /**
     * Permet d'accéder à la page partenaire
     *
     * @Route("/partenaire", name="sr_blog_partenaire" )
     */
    public function partenaireAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Partenaire', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:partenaire.html.twig');
    }

    /**
     * Permet d'accéder à la page seminaire et formation
     *
     * @Route("/seminaire-formation", name="sr_blog_seminaire_formation" )
     */
    public function seminaireFormationAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Séminaire et formations', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:seminaire_formation.html.twig');
    }

    /**
     * Permet d'accéder à la page groupes de parole
     *
     * @Route("/groupes-de-parole", name="sr_blog_groupes_parole" )
     */
    public function groupesDeParoleAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Groupes de parole', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:groupes_de_parole.html.twig');
    }

    /**
     * Permet d'accéder à la page visite mediatisee
     *
     * @Route("/visite-mediatisee", name="sr_blog_actions_visite_mediatisee" )
     */
    public function visiteMediatiseeAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Visite mediatisée', $this->get("router")->generate($request->get('_route')));

        return $this->render('SRBlogBundle:Main:visite_mediatisee.html.twig');
    }


    /**
     * Permet de rechercher du contenu à l'aide d'une chaine de caractère. La recheche permet de retourner les articles et/ou les events
     *
     * @Route("/search", name="sr_blog_search" )
     */
    public function searchAction(Request $request)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('Recherche', $this->get("router")->generate($request->get('_route')));

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



