<?php

namespace SR\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SR\BlogBundle\Entity\News;
use SR\UserBundle\Entity\User;
use SR\BlogBundle\Entity\Comment;
use SR\BlogBundle\Entity\NewsCategory;

use SR\BlogBundle\Form\NewsType;
use SR\BlogBundle\Form\CommentType;
use SR\BlogBundle\Form\NewsCategoryType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class NewsController extends Controller
{
    public function indexAction($page)
    {
        $nbPerPage = 3;
        // On récupère notre objet Paginator
        $listNews = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->myFindAll($page, $nbPerPage);
        // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
        $nbPages = ceil(count($listNews)/$nbPerPage);

        if ($page > $nbPages && $nbPages!=0 ) {
            throw $this->createNotFoundException('Pas de page pour ce numéro de page : '.$page);
        }

        return $this->render('SRBlogBundle:News:index.html.twig', [
            'listNews' => $listNews,
            'nbPages'  => $nbPages,
            'page'     => $page,
        ]);
    }

    public function viewAction(News $news, $slug)
    {
        if (!$news) {
            throw $this->createNotFoundException('Aucun article trouvée pour cet id : '.$news->getId());
        }

        $comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostNewsComments($news->getId());

        return $this->render('SRBlogBundle:News:view.html.twig', [
            'news' => $news,
            'comments' => $comments
        ]);
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(new NewsType, $news);
        $form->handleRequest($request);                     // La methode handleRequest permet de remplir notre objet $news avec les valeurs récpérer depuis la request

        if($form->isValid()) {

            $user = $this->getUser();
            $news->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('sr_blog_article_view', [
                'slug' => $news->getSlug(),
            ]));
        }
        return $this->render('SRBlogBundle:News:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Security(" has_role('ROLE_USER')")
    */
    public function updateAction(News $news, Request $request)
    {
        if (!$news) {
            throw $this->createNotFoundException('Aucun article trouvée pour cet id : '. $news->getId());
        }
        $form = $this->createForm(new NewsType, $news);
        $form->handleRequest($request);

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //Pas besoin de persister car doctrine sait qu'il doit le faire (on vient de le récupérer)
            $em->flush();
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            return $this->redirect($this->generateUrl('sr_blog_article_view', [
                'slug' => $news->getSlug(),
            ]));
        }
        return $this->render('SRBlogBundle:News:update.html.twig', [
            'form'   => $form->createView(),
        ]);
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */

    public function deleteAction(News $news, Request $request)
    {
        if (!$news) {
            throw $this->createNotFoundException('Aucun article trouvée pour cet id : '.$id);
        }
        $form = $this->createFormBuilder()->getForm();

        if($form->handleRequest($request)->isValid()) {
            $em    =   $this->getDoctrine()->getManager();
            $comments = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:Comment')->getPostNewsComments($news->getId());
            foreach ($comments as $comment) {
                $em->remove($comment);
            }
            $em->remove($news);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_article'));
        }

        return $this->render('SRBlogBundle:News:delete.html.twig', [
            'news' => $news,
            'form'   => $form->createView()
        ]);
    }

    public function menuAction($limit)
    {
        $listNews = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->getNewsHome($limit);

        return $this->render('SRBlogBundle:News:menu.html.twig', [
            'listNews'=>$listNews,
        ]);
    }

    /**
    * @Security("has_role('ROLE_USER')")
    */
    public function addCategoryAction(Request $request)
    {
        $newsCategory = new NewsCategory();
        $form = $this->createForm(new NewsCategoryType, $newsCategory);

        $form->handleRequest($request);
        if($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($newsCategory);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_article'));
        }

        return $this->render('SRBlogBundle:News:addCategory.html.twig', [
            'form'   => $form->createView(),
        ]);

    }
}
