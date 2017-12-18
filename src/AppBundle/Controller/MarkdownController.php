<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\Markdown;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Michelf\MarkdownExtra;


class MarkdownController extends Controller
{
    public function testAction($contentName)
    {
        $repository = $this->getDoctrine()->getRepository(Markdown::class);
        $product = $repository->findOneByName($contentName);

        $title=MarkdownExtra::defaultTransform($product->getContent());
        return new Response($title);
    }
}