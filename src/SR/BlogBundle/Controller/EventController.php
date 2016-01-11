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
class EventController extends Controller
{
    /**
     * Permet d'accéder à la liste des événements d'AHUEFA
     *
     * @Route("/", name="events" )
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
     * @Route("/{id}", name="show_event" )
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
    * Permet de récupérer le détail d'un évènement
    *
    * @Route("/{id}/add", name="add_event" )
    * @Security(" has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(new EventType, $event);
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
    * @Route("/{id}/update", name="update_event" )
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

        $form = $this->createForm(new EventType, $event);

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
     * @Route("/{id}/delete", name="delete_event" )
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Event $event, Request $request)
    {
        if (!$event) {
         throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
        }

        $form = $this->createFormBuilder()->getForm();
        
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
     * @Security("has_role('ROLE_USER')")
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
     * @Route("/ajout-categorie", name="add_event_category" )
     * @Security("has_role('ROLE_USER')")
     */
    public function addCategoryAction(Request $request)
    {
        $eventCategory = new EventCategory();
        $form = $this->createForm(new EventCategoryType, $eventCategory);
        $form->handleRequest($request);

        if($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($eventCategory);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_home'));
        }
        return $this->render('SRBlogBundle:Event:addCategory.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

