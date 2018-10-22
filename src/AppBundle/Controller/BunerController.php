<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Buner;
use AppBundle\Form\BunerType;
use Doctrine\ORM\EntityManagerInterface;

class BunerController extends Controller
{


    public function recentBunerAction(){
        $em = $this->getDoctrine()->getManager();
        $objs = $em->getRepository('AppBundle:Buner')->findAll();

        return $this->render(
            'buner/recent_list_news.html.twig',
            array('buners' => $objs)
        );
    }

    public function getBunerAction(){
        $em = $this->getDoctrine()->getManager();
        $objs = $em->getRepository('AppBundle:Buner')->findAll();

        return $objs;
    }

    /**
     * @Route("/admin/buner/{id}", name="EditBuner", requirements={"id": "\d+"})
     * @Route("/admin/buner", name="Buner", defaults={"id" = "0"}))
     */
    public function modAction($id)
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $objs = $em->getRepository('AppBundle:Buner')->findAll();
        
        if($id!=0){
            $obj = $em->getRepository('AppBundle:Buner')->find($id);
            if (!$obj) throw $this->createNotFoundException('Buner не существует');
        }else{
            $obj = new Buner();
        }
        $form = $form = $this->createForm(BunerType::class, $obj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $obj = $form->getData();
                $em = $this->getDoctrine()->getManager();
                if($id==0)$em->persist($obj);
                $em->flush();

                return $this->redirectToRoute('Buner',array('message'=>'sНовость сохранена'));
            }
            return $this->redirectToRoute('Buner',array('message'=>'iОперация отменена'));
        }

        if($id==0) return $this->render('buner/admin.html.twig', array('form' => $form->createView(),'objs' => $objs));
        else return $this->render('buner/admin.html.twig',array('form' => $form->createView(),'objs' => $objs,'obj' => $obj));
    }

    /**
     * @Route("/admin/buner/{id}/dell", name="DellBuner", requirements={"id": "\d+"})
     */
    public function dellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('AppBundle:Buner')->find($id);

        if (!$obj) throw $this->createNotFoundException('Buner не существует');

        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('Buner');
    }

}
