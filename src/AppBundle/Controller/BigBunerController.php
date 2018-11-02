<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\BigBuner;
use AppBundle\Form\BunerType;
use Doctrine\ORM\EntityManagerInterface;

class BigBunerController extends Controller
{


    public function recentAction(){
        $em = $this->getDoctrine()->getManager();
        $objs = $em->getRepository('AppBundle:BigBuner')->findAll();

        return $this->render(
            'bigbuner/recent_list_news.html.twig',
            array('buners' => $objs)
        );
    }

    public function getBigBunerAction(){
        $em = $this->getDoctrine()->getManager();
        $objs = $em->getRepository('AppBundle:BigBuner')->findAll();

        return $objs;
    }

    /**
     * @Route("/admin/bigbuner/{id}", name="EditBigBuner", requirements={"id": "\d+"})
     * @Route("/admin/bigbuner", name="BigBuner", defaults={"id" = "0"}))
     */
    public function modAction($id)
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $objs = $em->getRepository('AppBundle:BigBuner')->findAll();
        
        if($id!=0){
            $obj = $em->getRepository('AppBundle:BigBuner')->find($id);
            if (!$obj) throw $this->createNotFoundException('Buner не существует');
        }else{
            $obj = new BigBuner();
        }
        $form = $form = $this->createForm(BunerType::class, $obj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $obj = $form->getData();
                $em = $this->getDoctrine()->getManager();
                if($id==0)$em->persist($obj);
                $em->flush();

                return $this->redirectToRoute('BigBuner',array('message'=>'sНовость сохранена'));
            }
            return $this->redirectToRoute('BigBuner',array('message'=>'iОперация отменена'));
        }

        if($id==0) return $this->render('bigbuner/admin.html.twig', array('form' => $form->createView(),'objs' => $objs));
        else return $this->render('bigbuner/admin.html.twig',array('form' => $form->createView(),'objs' => $objs,'obj' => $obj));
    }

    /**
     * @Route("/admin/bigbuner/{id}/dell", name="DellBigBuner", requirements={"id": "\d+"})
     */
    public function dellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('AppBundle:BigBuner')->find($id);

        if (!$obj) throw $this->createNotFoundException('Buner не существует');

        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('BigBuner');
    }

}
