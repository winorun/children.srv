<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


use AppBundle\Entity\TextConfig;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

use Michelf\MarkdownExtra;


class MarkdownController extends Controller
{
    public function testAction($contentName)
    {
        $repository = $this->getDoctrine()->getRepository(TextConfig::class);
        $product = $repository->findOneByName($contentName);

        $title=($product)?MarkdownExtra::defaultTransform($product->getContent()):"";
        return new Response($title);
    }
}