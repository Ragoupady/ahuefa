<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SR\BlogBundle\Entity\Event;
use SR\UserBundle\Entity\User;
use SR\BlogBundle\Entity\Movie;
use SR\BlogBundle\Entity\EventCategory;
use SR\BlogBundle\Form\EventCategoryType;
use SR\BlogBundle\Form\EventType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * EventController : Ce controller permet de gérer les évenements
 *
 * @Route("/evenements")
 */
class EventController extends BlogController
{
    /**
     * Permet d'accéder à la liste des événements d'AHUEFA
     *
     * @Route("/evenement/page/{page}", name="sr_blog_evenement",requirements={"page" = "\d+"}, defaults={"page" = 1} )
     */
    public function indexAction($page)
    {
        $nbPerPage = 3;
        $listEvent = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Event')->myFindAll($page, $nbPerPage);
        // On calcule le nombre total de pages grâce au count($listEvent) qui retourne le nombre total d'evenement
        $nbPages = ceil(count($listEvent)/$nbPerPage);
         
        if ($page > $nbPages && $nbPages != 0 ) {
            throw $this->createNotFoundException('Pas de page pour ce numéro de page : '.$page);
        }
        return $this->render('SRBlogBundle:Event:index.html.twig', [
            'listEvent' => $listEvent,
            'nbPages'   => $nbPages,
            'page'      => $page,
        ]);
    }

    /**
     * Permet de récupérer le détail d'un évenement
     *
     * @Route("/evenement/{slug}", name="sr_blog_evenement_view" )
     */
    public function viewAction(Event $event, $slug)
    {
        if (!$event) {
          throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
        }
        $comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostEventComments($event->getId());
        
        return $this->render('SRBlogBundle:Event:view.html.twig', [
            'event' => $event,
            'comments' => $comments
        ]);
    }

    /**
    * Permet d'ajouter un évènement
    *
    * @Route("/add", name="sr_blog_evenement_add", options={"expose" = true} )
    * @Security(" has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(new EventType, $event, [
            'action' => $this->generateUrl('sr_blog_evenement_add'),
            'method' => 'POST'
        ]);
        $form->handleRequest($request);

        if($form->isValid()) {
            $user = $this->getUser();
            $event->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_evenement_view', array('slug' => $event->getSlug())));
        }

        return $this->render('SRBlogBundle:Event:add.html.twig',array('form' => $form->createView()));
    }

    /**
    * Permet de mettre à jour un évènement
    *
    * @Route("/evenement/update/{slug}", name="sr_blog_evenement_update", options={"expose" = true} )
    * @Security("has_role('ROLE_USER')")
    */
    public function updateAction(Event $event, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if (!$event) {
            throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
        }

        $originalMovies= new ArrayCollection();
        // Crée un tableau contenant les objets Movie courants de la base de données
        foreach ($event->getMovies() as $movie) {
            $originalMovies->add($movie);
        }

        $form = $this->createForm(new EventType, $event, [
            'action' => $this->generateUrl('sr_blog_evenement_update', [
                'slug' => $event->getSlug(),
            ])
        ]);

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {
                foreach ($originalMovies as $movie) {
                    
                    if($event->getMovies()->contains($movie) == false) {
                        $em->remove($movie);
                    }
                }
                $em->persist($event);
                $em->flush();             //Pas besoin de persister car doctrine sait qu'il doit le faire (on vient de le récupérer)

                return $this->redirect($this->generateUrl('sr_blog_evenement_view', array('slug' => $event->getSlug())));
            }
    
        }
        return $this->render('SRBlogBundle:Event:update.html.twig', [
            'slug' => $event->getSlug(),
            'form'=> $form->createView(),
        ]);
    }

    /**
     * Permet de supprimer un évènement
     *
     * @Route("/evenement/delete/{slug}", name="sr_blog_evenement_delete", options={"expose" = true} )
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Event $event, Request $request)
    {
        if (!$event) {
         throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
        }

        $form = $this->createDeleteForm($this->generateUrl('sr_blog_evenement_delete', [
            'slug' => $event->getSlug(),
        ]));
        
        if( $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_evenement'));
        }

        return $this->render('SRBlogBundle:Event:delete.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de récupérer les évènements à afficher dans la page d'accueil
     *
     * @Route("/menu", name="menu_event" )
     */
    public function menuAction($limit)
    {
        $listEvent = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Event')->getEventHome($limit);

        return $this->render('SRBlogBundle:Event:menu.html.twig',[
            'listEvent' => $listEvent,
        ]);
    }

    /**
     * Permet d'ajouter une nouvelle catégorie pour les événements
     *
     * @Route("/evenements/addCategory", name="sr_blog_evenement_add_category", options={"expose" = true} )
     * @Security("has_role('ROLE_USER')")
     */
    public function addCategoryAction(Request $request)
    {
        $eventCategory = new EventCategory();
        $form = $this->createForm(new EventCategoryType, $eventCategory, [
            'action' => $this->generateUrl('sr_blog_evenement_add_category'),
            'method' => 'POST'
        ]);

        $form->handleRequest($request);

        if($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($eventCategory);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_evenement'));
        }
        return $this->render('SRBlogBundle:Event:addCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

