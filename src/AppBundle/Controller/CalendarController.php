<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Calendar;
use AppBundle\Form\CalendarType;
use Doctrine\ORM\EntityManagerInterface;

class CalendarController extends Controller
{
    public function recentCalendarAction(){
        $em = $this->getDoctrine()->getManager();
        $repository=$em->getRepository('AppBundle:Calendar');

        $date = new \DateTime;

        $query = $repository->createQueryBuilder('p')
                ->andWhere('p.date > :date')
                ->setParameter('date', $date )
                ->orderBy('p.date', 'ASC')
                ->getQuery();

        $objs = $query->getResult();

        return $this->render(
            'calendar/recent_events.html.twig',
            array('events' => $objs,'date' => $date)
        );
    }

    /**
     * @Route("calendar", name="showCalendar")
     *
     */
    public function showAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $repository=$em->getRepository('AppBundle:Calendar');

        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.date', 'ASC')
                ->getQuery();

        $objs = $query->getResult();

        $date = new \DateTime;

        return $this->render('calendar/list.html.twig',array('events'=>$objs,'date'=>$date));
    }


    /**
     * @Route("/admin/calendar/{id}", name="EditEvent", requirements={"id": "\d+"})
     * @Route("/admin/calendar", name="Calendar", defaults={"id" = "0"}))
     */
    public function modAction($id)
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $repository=$em->getRepository('AppBundle:Calendar');

        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.date', 'ASC')
                ->getQuery();

        $objs = $query->getResult();
        
        if($id!=0){
            $obj = $em->getRepository('AppBundle:Calendar')->find($id);
            if (!$obj) throw $this->createNotFoundException('Событие не существует');
        }else{
            $obj = new Calendar();
        }
        $form = $form = $this->createForm(CalendarType::class, $obj);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $obj = $form->getData();
                $em = $this->getDoctrine()->getManager();
                if($id==0)$em->persist($obj);
                $em->flush();

                return $this->redirectToRoute('Calendar',array('message'=>'sCохранено'));
            }
            return $this->redirectToRoute('Calendar',array('message'=>'iОперация отменена'));
        }

        if($id==0) return $this->render('calendar/admin.html.twig', array('form' => $form->createView(),'objs' => $objs));
        else return $this->render('calendar/admin.html.twig',array('form' => $form->createView(),'objs' => $objs,'obj' => $obj));
    }

    /**
     * @Route("/admin/calendar/{id}/dell", name="DellEvent", requirements={"id": "\d+"})
     */
    public function dellAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $obj = $em->getRepository('AppBundle:Calendar')->find($id);

        if (!$obj) throw $this->createNotFoundException('Calendar не существует');

        $em->remove($obj);
        $em->flush();
        return $this->redirectToRoute('Calendar');
    }

}
