<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SR\BlogBundle\Entity\Event;
use SR\BlogBundle\Entity\News;
use SR\UserBundle\Entity\User;
use SR\BlogBundle\Entity\Comment;
use SR\BlogBundle\Form\CommentType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CommentController extends Controller
{


	public function newNewsAction(News $news)
	{

			$comment = new Comment();
			$comment->setNews($news);

			$form   = $this->createForm(new CommentType(), $comment);

			return $this->render('SRBlogBundle:Comment:formNews.html.twig', array(
	            																	'comment' => $comment,
	           																	    'form'   => $form->createView()
       		 ));		

		

	}



	public function newEventAction(Event $event)
	{
		

			$comment = new Comment();
			$comment->setEvent($event);

			$form   = $this->createForm(new CommentType(), $comment);

			return $this->render('SRBlogBundle:Comment:formEvent.html.twig', array(
	            																	'comment' => $comment,
	           																	    'form'   => $form->createView()
       		 ));		

		
		
	}


	public function createNewsAction($id, Request $request)
	{
		//récupérer la news à l'aide de l'id
		$news = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->find($id);
		if (!$news) {
       	 throw $this->createNotFoundException('Aucun article trouvée pour cet id : '.$id);
        }
		//créer un commentaire
		$comment = new Comment();
   		$comment->setNews($news);


		//créer un formulaire avec ce commentaire vide
		$form = $this->createForm(new CommentType,$comment);

		$form->handleRequest($request);



		
			if ($form->isValid()){ 
				// ajouter la news dans le comment
				$user = $this->getUser();


				$comment->setUser($user);

				$em = $this->getDoctrine()->getManager();

	            $em->persist($comment);
	            $em->flush();
				//persister , ne pas oublier user etc...
				//rediriger sur la page de vue en donnant l'id de la news
				

				return $this->redirect($this->generateUrl('sr_blog_article_view', array(
	               							'slug' => $comment->getNews()->getSlug())) .'#comment-' . $comment->getId()
	           	 );
			}
		
		//retourner ce formulaire dans une vue qui va afficher le form
		//Donner la news au formulaire	

   		$comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostComments($id);

       	return $this->render('SRBlogBundle:News:view.html.twig', array('news' => $news,
                                                                       'comments' => $comments
                                                                       ));

	}



	public function createEventAction(Event $event, Request $request)
	{

		if (!$event) {
        	throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$id);
        }
		//créer un commentaire
		$comment = new Comment();
   		$comment->setEvent($event);

   		


		//créer un formulaire avec ce commentaire vide
		$form = $this->createForm(new CommentType,$comment);

		$form->handleRequest($request);



		
			if ($form->isValid()){ 
				// ajouter l'event dans le comment
				

				//Partie à changer par du dynamique
	            $user = $this->getUser();
				$comment->setUser($user);

				$em = $this->getDoctrine()->getManager();
	            
	            $em->persist($comment);
	            $em->flush();
				
				//rediriger sur la page de vue en donnant l'id de l'event
				

				return $this->redirect($this->generateUrl('sr_blog_evenement_view', array(
	               							'slug' => $comment->getEvent()->getSlug())) .'#comment-' . $comment->getId()
	           	 );
			}
		
		//retourner ce formulaire dans une vue qui va afficher le form
		//Donner l'event au formulaire	

		return $this->render('SRBlogBundle:Comment:create.html.twig',array('comment' => $comment,
																			 'form'    => $form->createView()));
       	

	}


	public function deleteNewsAction($id,Request $request)
	{
		$comment = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->find($id);
		if (!$comment) {
        	throw $this->createNotFoundException('Aucun commentaire trouvée pour cet id : '.$id);
        }

         // On crée un formulaire vide, qui ne contiendra que le champ CSRF
         // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid())
        { 

			$em = $this->getDoctrine()->getManager();
			$em->remove($comment);
			$em->flush();

			return $this->redirect($this->generateUrl('sr_blog_article_view', array('slug'=> $comment->getNews()->getSlug())));
		
		}
		
		return $this->render('SRBlogBundle:Comment:deleteNews.html.twig', array('comment' => $comment,
                                                                         'form'   => $form->createView()));
	}



	public function deleteEventAction($id,Request $request)
	{
		$comment = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->find($id);
		if (!$comment) {
        	throw $this->createNotFoundException('Aucun commentaire trouvée pour cet id : '.$id);
        }

         // On crée un formulaire vide, qui ne contiendra que le champ CSRF
         // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid())
        { 

			$em = $this->getDoctrine()->getManager();
			$em->remove($comment);
			$em->flush();

			return $this->redirect($this->generateUrl('sr_blog_evenement_view', array('slug'=> $comment->getEvent()->getSlug())));
		
		}
		
		return $this->render('SRBlogBundle:Comment:deleteEvent.html.twig', array('comment' => $comment,
                                                                         'form'   => $form->createView()));
	}
}


?>