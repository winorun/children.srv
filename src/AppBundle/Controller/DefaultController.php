<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\Markdown;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Michelf\MarkdownExtra;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
       return $this->render('base.html.twig');
    }

    /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Markdown::class);
        $product = $repository->findOneByName('sitebar');

        $title=MarkdownExtra::defaultTransform($product->getContent());
       return $this->render('test.html.twig',array('title' => $title));
    }
}