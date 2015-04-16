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


	public function newAction($item)
	{
		
		if($item instanceof News)
		{

			$comment = new Comment();
			$comment->setNews($item);

			$form   = $this->createForm(new CommentType(), $comment);

			return $this->render('SRBlogBundle:Comment:formNews.html.twig', array(
	            																	'comment' => $comment,
	           																	    'form'   => $form->createView()
       		 ));		

		}

		if($item instanceof Event)
		{

			$comment = new Comment();
			$comment->setEvent($item);

			$form   = $this->createForm(new CommentType(), $comment);

			return $this->render('SRBlogBundle:Comment:formEvent.html.twig', array(
	            																	'comment' => $comment,
	           																	    'form'   => $form->createView()
       		 ));		

		
		}
		

	}


	public function createNewsAction($id, Request $request)
	{
		//récupérer la news à l'aide de l'id
		$news = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->find($id);
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
	               							'id' => $comment->getNews()->getId())) .'#comment-' . $comment->getId()
	           	 );
			}
		
		//retourner ce formulaire dans une vue qui va afficher le form
		//Donner la news au formulaire	

   		$comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostComments($id);

       	return $this->render('SRBlogBundle:News:view.html.twig', array('news' => $news,
                                                                       'comments' => $comments
                                                                       ));

	}


	public function createEventAction($id, Request $request)
	{
		//récupérer l'event à l'aide de l'id
		$event = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Event')->find($id);
		//créer un commentaire
		$comment = new Comment();
   		$comment->setEvent($event);


		//créer un formulaire avec ce commentaire vide
		$form = $this->createForm(new CommentType,$comment);

		$form->handleRequest($request);



		
			if ($form->isValid()){ 
				// ajouter l'event dans le comment
				

				//Partie à changer par du dynamique
	            $user = new User();
	            $user->setLastName('SAGADEVIN');
	            $user->setFirstName('ragoupady');
	            $user->setLogin('oub24');   
	            $user->setPassword('password');
	            $user->setEmail('ragou@fake.fr');
				$comment->setUser($user);

				$em = $this->getDoctrine()->getManager();
	            $em->persist($user);
	            $em->persist($comment);
	            $em->flush();
				//persister , ne pas oublier user etc...
				//rediriger sur la page de vue en donnant l'id de la news
				

				return $this->redirect($this->generateUrl('sr_blog_evenement_view', array(
	               							'id' => $comment->getEvent()->getId())) .'#comment-' . $comment->getId()
	           	 );
			}
		
		//retourner ce formulaire dans une vue qui va afficher le form
		//Donner l'event au formulaire	

		return $this->render('SRBlogBundle:Comment:create.html.twig',array('comment' => $comment,
																			 'form'    => $form->createView()));
       	

	}


	public function deleteAction($id,Request $request)
	{
		$comment = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->find($id);

         // On crée un formulaire vide, qui ne contiendra que le champ CSRF
         // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid())
        { 

			$em = $this->getDoctrine()->getManager();
			$em->remove($comment);
			$em->flush();

			return $this->redirect($this->generateUrl('sr_blog_article_view', array('id'=> $comment->getNews()->getId())));
		
		}
		
		return $this->render('SRBlogBundle:Comment:delete.html.twig', array('comment' => $comment,
                                                                         'form'   => $form->createView()));
	}
}


?>