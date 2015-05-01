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

class EventController extends Controller
{
    public function indexAction($page)
    {
        

         // Ici je fixe le nombre d'evenement par page à 3
         // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
        $nbPerPage = 3;
        

            // On récupère notre objet Paginator
        $listEvent = $this->getDoctrine()
      ->getManager()
      ->getRepository('SRBlogBundle:Event')
      ->myFindAll($page, $nbPerPage)
    ;
        // On calcule le nombre total de pages grâce au count($listEvent) qui retourne le nombre total d'evenement
         $nbPages = ceil(count($listEvent)/$nbPerPage);
         
        if ($page > $nbPages && $nbPages != 0 ) 
        {
            throw $this->createNotFoundException('Pas de page pour ce numéro de page : '.$page);
        }

        return $this->render('SRBlogBundle:Event:index.html.twig', array('listEvent' => $listEvent,
                                                                        'nbPages'  => $nbPages,
                                                                        'page'     => $page));
    }       

    public function viewAction(Event $event, $slug)
    {
        

        if (!$event) {
          throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
        }

        $comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostEventComments($event->getId());
        
        return $this->render('SRBlogBundle:Event:view.html.twig', array('event' => $event,
                                                                       'comments' => $comments
                                                                       ));
    
    }

    /**
    * @Security(" has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
        
        
        $event = new Event();
        $form = $this->createForm(new EventType, $event);
        $form->handleRequest($request);

        if($form->isValid())
        {
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
    * @Security("has_role('ROLE_USER')")
    */
    public function updateAction(Event $event, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        

        if (!$event) {
            throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
        }

        $originalMovies= new ArrayCollection();

          // Crée un tableau contenant les objets Movie courants de la
         // base de données

        foreach ($event->getMovies() as $movie) {
            $originalMovies->add($movie);
        }

        $form = $this->createForm(new EventType, $event);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if($form->isValid())
            {
                foreach ($originalMovies as $movie) {
                    
                    if($event->getMovies()->contains($movie) == false)
                    {
                        $em->remove($movie);
                    }
                }
                $em->persist($event);
                $em->flush();             //Pas besoin de persister car doctrine sait qu'il doit le faire (on vient de le récupérer)

                return $this->redirect($this->generateUrl('sr_blog_evenement_view', array('slug' => $event->getSlug())));
            }
    
        }

        return $this->render('SRBlogBundle:Event:update.html.twig', array('slug' => $event->getSlug(),
                                                                          'form'=> $form->createView()
            ));
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function deleteAction(Event $event, Request $request)
    {
        
        if (!$event) {
         throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
        }
          
          // On crée un formulaire vide, qui ne contiendra que le champ CSRF
         // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();
        
        if( $form->handleRequest($request)->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($event);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_evenement'));
        }



        return $this->render('SRBlogBundle:Event:delete.html.twig', array('event' => $event,
                                                                          'form' => $form->createView()));
    }

    public function menuAction($limit)
    {
        $listEvent = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Event')->getEventHome($limit);

        return $this->render('SRBlogBundle:Event:menu.html.twig',array('listEvent' => $listEvent));

    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addCategoryAction(Request $request)
    {
        
        $eventCategory = new EventCategory();
        $form = $this->createForm(new EventCategoryType, $eventCategory);
        $form->handleRequest($request);

        if($form->isValid())
        {

            $em = $this->getDoctrine()->getManager();
            $em->persist($eventCategory);
            $em->flush();
            

            return $this->redirect($this->generateUrl('sr_blog_home'));


        }

        return $this->render('SRBlogBundle:Event:addCategory.html.twig',array('form' => $form->createView()));
    }
}

