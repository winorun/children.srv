<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Image;
use AppBundle\Form\ImageType;

class ImageController extends Controller
{
    /**
     * @Route("/admin/img", name="imageList")
     *
     */
    public function showListAction(Request $request){

    	$em = $this->getDoctrine()->getManager();
        $imgs = $em->getRepository('AppBundle:Image')->findAll();

        $img = new Image();

        $form = $form = $this->createForm(ImageType::class, $img);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $img = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($img);
                $em->flush();

                return $this->redirectToRoute('imageList');
            }
            return $this->redirectToRoute('imageList');
        }

        return $this->render('img/list.html.twig',array('imgs'=>$imgs,'form' => $form->createView()));
    }

    /**
     * @Route("/admin/img/dell/{id}", name="dellImg", requirements={"id": "\d+"})
     */
    public function dellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $img = $em->getRepository('AppBundle:Image')->find($id);

        if (!$img) throw $this->createNotFoundException('Страница не найденна');

        $em->remove($img);
        $em->flush();
        return $this->redirectToRoute('imageList',array('message'=>'sСтраница удаленна'));
    }

}