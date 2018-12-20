<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Michelf\MarkdownExtra;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;

class ArticleController extends Controller
{
    /**
     * @Route("/article/{id}", name="showArticle", requirements={"id": "\d+"}, defaults={"special" = false})
     * @Route("/special/article/{id}", requirements={"id": "\d+"}, defaults={"special" = true})
     */
    public function showPageAction($id,$special){

    	$em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (!$article) throw $this->createNotFoundException('Страница не найденна');

        $article->setContent(MarkdownExtra::defaultTransform($article->getContent()));
        if ($special) return $this->render('special/article.html.twig',array('article'=>$article));
        return $this->render('article/show.html.twig',array('article'=>$article));
    }  

    /**
     * @Route("/admin/article", name="articleList")
     *
     */
    public function showListAction(Request $request){

    	$em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findAll();

        return $this->render('article/list.html.twig',array('article'=>$article));
    }

    /**
     * @Route("/admin/article/edd/{id}", name="editArticle", requirements={"id": "\d+"})
     */
    public function eddAction($id)
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (!$article) throw $this->createNotFoundException('Страница не найденна');

        $form = $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $article = $form->getData();
                $em = $this->getDoctrine()->getManager();
                // $em->persist($article);
                $em->flush();

                return $this->redirectToRoute('showArticle',array('id' => $article->getId()));
            }
            return $this->redirectToRoute('articleList');
        }

        return $this->render('article/form.html.twig', array(
            'form' => $form->createView(),'article'=> $article
        ));


        return $this->render('article/form.html.twig',array('article'=>$article));
    }

    /**
     * @Route("/admin/article/add", name="addArticle")
     */
    public function addAction(Request $request)
    {
        $article = new Article();

        $form = $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $article = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();

                return $this->redirectToRoute('showArticle',array('id' => $article->getId()));
            }
            return $this->redirectToRoute('articleList');
        }

        return $this->render('article/form.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/article/dell/{id}", name="dellArticle", requirements={"id": "\d+"})
     */
    public function dellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        if (!$article) throw $this->createNotFoundException('Страница не найденна');

        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute('articleList',array('message'=>'sСтраница удаленна'));
    }

}