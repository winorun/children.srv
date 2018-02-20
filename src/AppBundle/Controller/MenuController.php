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
    public function showUserMenuAction($yaml=NULL)
    {
    	if($yaml==NULL){
    		$repository = $this->getDoctrine()->getRepository(TextConfig::class);
	        $menu = $repository->findOneByName('menu');
			if (!$menu) throw $this->createNotFoundException('Нас взламывают');//:)
			$yaml = Yaml::parse($menu->getContent());
    	}
       return $this->render('user_menu.html.twig',array('yaml'=>$yaml));
    }
}