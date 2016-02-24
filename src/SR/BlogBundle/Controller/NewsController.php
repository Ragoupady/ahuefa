<?php

namespace SR\BlogBundle\Controller;

use SR\BlogBundle\Entity\News;
use SR\BlogBundle\Entity\NewsCategory;
use SR\BlogBundle\Form\NewsType;
use SR\BlogBundle\Form\NewsCategoryType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Annotation\Route;

/**
 * NewsController : Ce controller permet de gérer les articles (news)
 *
 * @Route("/articles")
 */
class NewsController extends BlogController
{
    /**
     * Permet d'accéder à la liste des articles d'AHUEFA
     *
     * @Route("/page/{page}", name="sr_blog_article", requirements={"page" = "\d+"}, defaults={"page" = 1} )
     */
    public function indexAction(Request $request, $page)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('articles', $this->get("router")->generate($request->get('_route')));

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

    /**
     * Permet de voir le détail d'un article
     *
     * @Route("/articles/{slug}", name="sr_blog_article_view" )
     */
    public function viewAction(Request $request, News $news, $slug)
    {
        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $breadcrumbs->addItem('Accueil', $this->get("router")->generate('sr_blog_home'));
        $breadcrumbs->addItem('articles', $this->get("router")->generate('sr_blog_article'));
        $breadcrumbs->addItem($slug, $this->get("router")->generate($request->get('_route'), [
            'slug' => $slug
        ]));

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
    * Permet d'ajouter un nouvel article
    *
    * @Route("/add", name="sr_blog_article_add", options={"expose"=true} )
    * @Security("has_role('ROLE_USER')")
    */
    public function addAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(new NewsType, $news, [
            'action' => $this->generateUrl('sr_blog_article_add'),
            'method' => 'POST'
        ]);

        if ($request->isXmlHttpRequest()) {

            return $this->render('SRBlogBundle:News:add.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $form->handleRequest($request);
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
    }

    /**
     * Permet de mettre à jour un article
     *
     * @Route("/articles/update/{slug}", name="sr_blog_article_update", options={"expose" = true} )
     * @Security("has_role('ROLE_USER')")
     */
    public function updateAction(Request $request, News $news)
    {
        if (!$news) {
            throw $this->createNotFoundException('Aucun article trouvée pour cet id : '. $news->getId());
        }
        $form = $this->createForm(new NewsType, $news, [
            'action' => $this->generateUrl('sr_blog_article_update', [
                'slug' => $news->getSlug(),
            ]),
            'method' => 'POST',
        ]);

        if ($request->isXmlHttpRequest()) {
            return $this->render('SRBlogBundle:News:update.html.twig', [
                'form'   => $form->createView(),
                'news'   => $news,
            ]);
        }

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
    }

    /**
     * Permet de supprimer un article
     *
     * @Route("/articles/delete/{slug}", name="sr_blog_article_delete" , options={"expose" = true})
     * @Security("has_role('ROLE_USER')")
     */
    public function deleteAction(Request $request, News $news)
    {
        if (!$news) {
            throw $this->createNotFoundException('Aucun article trouvée pour cet id : '.$news->getId());
        }

        $form = $this->createDeleteForm($this->generateUrl('sr_blog_article_delete', [
            'slug' => $news->getSlug(),
        ]));

        if ($request->isXmlHttpRequest()) {

            return $this->render('SRBlogBundle:News:delete.html.twig', [
                'news' => $news,
                'form'   => $form->createView()
            ]);
        }

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

    }

    /**
     * Permet de récupérer la liste des articles à afficher dans la page d'accueil
     *
     * @Route("/menu", name="menu_news" )
     */
    public function menuAction($limit)
    {
        $listNews = $this->getDoctrine()->getManager()->getRepository('SRBlogBundle:News')->getNewsHome($limit);

        return $this->render('SRBlogBundle:News:menu.html.twig', [
            'listNews'=>$listNews,
        ]);
    }

    /**
     * Permet d'ajouter une catégorie aux articles
     *
     * @Route("/article/addCategory", name="sr_blog_article_addCategory", options={"expose"=true}  )
     * @Security("has_role('ROLE_USER')")
     */
    public function addCategoryAction(Request $request)
    {
        $newsCategory = new NewsCategory();
        $form = $this->createForm(new NewsCategoryType, $newsCategory,[
            'method' => 'POST',
            'action' => $this->generateUrl('sr_blog_article_addCategory')
        ]);

        if ($request->isXmlHttpRequest()) {
            return $this->render('SRBlogBundle:News:addCategory.html.twig', [
                'form'   => $form->createView(),
            ]);
        }

        $form->handleRequest($request);
        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsCategory);
            $em->flush();

            return $this->redirect($this->generateUrl('sr_blog_article'));
        }

    }
}
