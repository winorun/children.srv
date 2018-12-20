<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use AppBundle\Entity\Article;
use AppBundle\Entity\News;

class DefaultController extends Controller
{

    /**
     * @Route("/special", name="homepage-special")
     */
    public function specialAction(Request $request)
    {
        // replace this example code with whatever you need
       return $this->render('special/main.html.twig');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
       return $this->render('main.html.twig');
    }

    /**
     * @Route("/sitemap.xml", defaults={"_format"="xml"}, name="Sitemap")
     */
    public function sitemapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findAll();
        $news = $em->getRepository('AppBundle:News')->findAll();

        $response = new Response();
        $response->headers->set('Content-Type', 'xml');

        return $this->render('admin/sitemap.xml.twig',array('article'=>$article,'news'=>$news));
    }

 
    /**
     * @Route("/search", name="Search")
     */
    public function searchAction(Request $request)
    {
        $seachString="http://google.ru/search?q=site:".$request->headers->get('host').
        " ".$request->get('query');
        return $this->redirect($seachString);

    }

}