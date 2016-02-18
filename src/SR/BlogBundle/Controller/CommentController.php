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
use Symfony\Component\Routing\Annotation\Route;

/**
 * CommentController : Ce controller permet de gérer les commentaires
 *
 * @Route("/commentaire")
 */
class CommentController extends Controller
{
	/**
	 * Permet d'accéder à la page membre
	 *
	 * @Route("/membre", name="membre" )
	 */
	public function newNewsAction(News $news)
	{
		$comment = new Comment();
		$comment->setNews($news);
		$form   = $this->createForm(new CommentType(), $comment);

		return $this->render('SRBlogBundle:Comment:formNews.html.twig', [
			'comment' => $comment,
			'form'   => $form->createView(),
		]);
	}

	public function newEventAction(Event $event)
	{
		$comment = new Comment();
		$comment->setEvent($event);
		$form   = $this->createForm(new CommentType(), $comment);

		return $this->render('SRBlogBundle:Comment:formEvent.html.twig', [
			'comment' => $comment,
			'form'   => $form->createView()
		]);
	}

    /**
     * Permet de creer un commentaire pour une news
     *
     * @Route("/article/comment/{id}", name="sr_blog_comment_create_news" )
     */
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

		if ($form->isValid()) {
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
   		$comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostComments($id);

       	return $this->render('SRBlogBundle:News:view.html.twig', [
			'news' => $news,
			'comments' => $comments
		]);

	}

    /**
     * Permet de creer un commentaire pour un événement
     *
     * @Route("/evenement/comment/{id}", name="sr_blog_comment_create_event" )
     */
	public function createEventAction(Event $event, Request $request)
	{
		if (!$event) {
        	throw $this->createNotFoundException('Aucun évenement trouvée pour cet id : '.$event->getId());
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

			return $this->redirect($this->generateUrl('sr_blog_evenement_view', array(
										'slug' => $comment->getEvent()->getSlug())) .'#comment-' . $comment->getId()
			 );
		}

		return $this->render('SRBlogBundle:Comment:create.html.twig', [
			'comment' => $comment,
			'form'    => $form->createView()
		]);
	}

    /**
     * Permet de supprimer un commentaire pour un article
     *
     * @Route("/article/comment/delete/{id}", name="sr_blog_article_comment_delete" )
     */
	public function deleteNewsAction(Request $request, $id)
	{
		$comment = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->find($id);
		if (!$comment) {
        	throw $this->createNotFoundException('Aucun commentaire trouvée pour cet id : '.$id);
        }
        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid())
        {
			$em = $this->getDoctrine()->getManager();
			$em->remove($comment);
			$em->flush();

			return $this->redirect($this->generateUrl('sr_blog_article_view', array('slug'=> $comment->getNews()->getSlug())));
		}
		return $this->render('SRBlogBundle:Comment:deleteNews.html.twig', [
			'comment' => $comment,
			'form'   => $form->createView()
		]);
	}

    /**
     * Permet de supprimer un commentaire pour un évènement
     *
     * @Route("/evenement/comment/delete/{id}", name="sr_blog_evenement_comment_delete" )
     */
	public function deleteEventAction($id,Request $request)
	{
		$comment = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->find($id);
		if (!$comment) {
        	throw $this->createNotFoundException('Aucun commentaire trouvée pour cet id : '.$id);
        }

        $form = $this->createFormBuilder()->getForm();
        if($form->handleRequest($request)->isValid())
        {
			$em = $this->getDoctrine()->getManager();
			$em->remove($comment);
			$em->flush();

			return $this->redirect($this->generateUrl('sr_blog_evenement_view', [
				'slug'=> $comment->getEvent()->getSlug(),
			]));
		}
		return $this->render('SRBlogBundle:Comment:deleteEvent.html.twig', array('comment' => $comment,
                                                                         'form'   => $form->createView()));
	}
}
