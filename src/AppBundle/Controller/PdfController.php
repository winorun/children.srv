<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Pdf;
use AppBundle\Form\PdfType;

class PdfController extends Controller
{
    /**
     * @Route("/pdf/{id}", name="showPdf", requirements={"id": "\d+"})
     *
     */
    public function showPdfAction($id){

    	$em = $this->getDoctrine()->getManager();
        $pdf = $em->getRepository('AppBundle:Pdf')->find($id);

        if (!$pdf) throw $this->createNotFoundException('Страница не найденна');

        return $this->render('pdf/show.html.twig',array('pdf'=>$pdf));
    }  

    /**
     * @Route("/admin/pdf", name="pdfList")
     *
     */
    public function showListAction(Request $request){

    	$em = $this->getDoctrine()->getManager();
        $pdfs = $em->getRepository('AppBundle:Pdf')->findAll();

        $pdf = new Pdf();

        $form = $form = $this->createForm(PdfType::class, $pdf);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $pdf = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($pdf);
                $em->flush();

                return $this->redirectToRoute('pdfList');
            }
            return $this->redirectToRoute('pdfList');
        }

        return $this->render('pdf/list.html.twig',array('pdfs'=>$pdfs,'form' => $form->createView()));
    }

    /**
     * @Route("/admin/pdf/dell/{id}", name="dellPdf", requirements={"id": "\d+"})
     */
    public function dellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $pdf = $em->getRepository('AppBundle:Pdf')->find($id);

        if (!$pdf) throw $this->createNotFoundException('Страница не найденна');

        $em->remove($pdf);
        $em->flush();
        return $this->redirectToRoute('pdfList',array('message'=>'sСтраница удаленна'));
    }

}