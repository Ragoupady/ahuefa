<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SR\BlogBundle\Entity\News;
use SR\UserBundle\Entity\User;
use SR\BlogBundle\Form\NewsType;
use SR\BlogBundle\Form\CommentType;
use SR\BlogBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NewsController extends Controller
{
    public function indexAction($page)
    {
         // Ici je fixe le nombre d'annonces par page à 3
         // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
        $nbPerPage = 3;
        
        // On récupère notre objet Paginator
        $listNews = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->myFindAll($page, $nbPerPage);
        // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
        $nbPages = ceil(count($listNews)/$nbPerPage);

        return $this->render('SRBlogBundle:News:index.html.twig', array('listNews' => $listNews,
                                                                        'nbPages'  => $nbPages,
                                                                        'page'     => $page));
    }

    public function viewAction($id)
    {
        $news = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->find($id);
        $comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostComments($id);

        return $this->render('SRBlogBundle:News:view.html.twig', array('news' => $news,
                                                                       'comments' => $comments
                                                                       ));
    }

    



    public function addAction(Request $request)
    {


        $news = new News();
        $form = $this->createForm(new NewsType, $news);
        $form->handleRequest($request);                     // La methode handleRequest permet de remplir notre objet $news avec les valeurs récpérer depuis la request

        if($form->isValid())
        {

            $user = $this->getUser();
            $news->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
            
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');


            return $this->redirect($this->generateUrl('sr_blog_article_view', array('id' => $news->getId())));
        }

        return $this->render('SRBlogBundle:News:add.html.twig', array('form' => $form->createView()));
    }

   

    /**
    * @Security(" has_role('ROLE_ADMIN')")
    */
    public function updateAction($id, Request $request)
    {
        $news = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->find($id);
        $form = $this->createForm(new NewsType, $news);
        
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            //Pas besoin de persister car doctrine sait qu'il doit le faire (on vient de le récupérer)
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            return $this->redirect($this->generateUrl('sr_blog_article_view', array('id' => $news->getId())));
    }
            //si c'est la premiere fois qu'on arrive dans la page ou que le formulaire est invalide, on montre le formulaire de mofification
            return $this->render('SRBlogBundle:News:update.html.twig', array('form'   => $form->createView()));
    }

        
    /**
    * @Security("has_role('ROLE_MODERATEUR')")
    */

    public function deleteAction($id, Request $request)
    {
        $news = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->find($id);

         // On crée un formulaire vide, qui ne contiendra que le champ CSRF
         // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid())
        {    

             $em    =   $this->getDoctrine()->getManager();
             $em->remove($news);
             $em->flush();

             return $this->redirect($this->generateUrl('sr_blog_article'));
        }

        return $this->render('SRBlogBundle:News:delete.html.twig', array('news' => $news,
                                                                         'form'   => $form->createView()));
    }

    public function menuAction($limit)
    {   


        $listNews = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->getNewsHome($limit);

        return $this->render('SRBlogBundle:News:menu.html.twig', array('listNews'=>$listNews));

    }
}
