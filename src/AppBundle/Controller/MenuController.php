<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Yaml\Yaml;
use AppBundle\Entity\TextConfig;

class MenuController extends Controller
{
    /**
     * @todo добавить валидацию и проверки
     */
    public function showUserMenuAction($contentName='menu')
    {
        $repository = $this->getDoctrine()->getRepository(TextConfig::class);
        $text = $repository->findOneByName('menu');

		$yaml = Yaml::parse($text->getContent());

       return $this->render('user_menu.html.twig',array('yaml'=>$yaml));
    }
}