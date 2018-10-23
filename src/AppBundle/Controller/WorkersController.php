<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Workers;
use AppBundle\Form\WorkersType;
use Doctrine\ORM\EntityManagerInterface;

class WorkersController extends Controller
{

    /**
     * @Route("/workers", name="ShowWorkers")
     */
    public function showAction()
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('AppBundle:Workers')->findAll();
        if (!$obj) throw $this->createNotFoundException('Workers не существует');
        return $this->render('workers/show.html.twig', array('objs' => $obj));
    }


    /**
     * @Route("/admin/workers/{id}", name="EditWorkers", requirements={"id": "\d+"})
     * @Route("/admin/workers", name="Workers", defaults={"id" = "0"}))
     */
    public function modAction($id)
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $objs = $em->getRepository('AppBundle:Workers')->findAll();
        
        if($id!=0){
            $obj = $em->getRepository('AppBundle:Workers')->find($id);
            if (!$obj) throw $this->createNotFoundException('Worker не существует');
        }else{
            $obj = new Workers();
        }
        $form = $form = $this->createForm(WorkersType::class, $obj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $obj = $form->getData();
                $em = $this->getDoctrine()->getManager();
                if($id==0)$em->persist($obj);
                $em->flush();

                return $this->redirectToRoute('Workers',array('message'=>'sНовость сохранена'));
            }
            return $this->redirectToRoute('Workers',array('message'=>'iОперация отменена'));
        }

        if($id==0) return $this->render('workers/admin.html.twig', array('form' => $form->createView(),'objs' => $objs));
        else return $this->render('workers/admin.html.twig',array('form' => $form->createView(),'objs' => $objs,'obj' => $obj));
    }

    /**
     * @Route("/admin/workers/{id}/dell", name="DellWorkers", requirements={"id": "\d+"})
     */
    public function dellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('AppBundle:Workers')->find($id);

        if (!$obj) throw $this->createNotFoundException('Workers не существует');

        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('Workers');
    }

}
