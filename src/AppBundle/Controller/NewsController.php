<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Michelf\MarkdownExtra;

use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
use Doctrine\ORM\EntityManagerInterface;

class NewsController extends Controller
{


    public function recentNewsAction($max = 6,$special=false){

        $repository = $this->getDoctrine()->getRepository(News::class);
        if($max != 0){
            $query = $repository->createQueryBuilder('p')
                ->orderBy('p.publicationDate', 'DESC')
                ->setMaxResults( $max )
                ->getQuery();
        }else{
            $query = $repository->createQueryBuilder('p')
                ->orderBy('p.publicationDate', 'DESC')
                ->getQuery();
        }


        $news = $query->getResult();
        // $news = $query->setMaxResults(1)->getOneOrNullResult();

        if (!$news) throw $this->createNotFoundException('Новость не найденна');
        if ($special) return $this->render('special/recent_list_news.html.twig',array('news' => $news));
        return $this->render('news/recent_list_news.html.twig',array('news' => $news));
    }

    /**
     * @Route("/news/{page}", name="ShowNews", requirements={"page": "\d+"},defaults={"special" = false})
     * @Route("/special/news/{page}", requirements={"id": "\d+"}, defaults={"special" = true})
     */
    public function showAction($page,$special)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('AppBundle:News')->find($page);

        if (!$news) throw $this->createNotFoundException('Новость не найденна');
        $news->setContent(MarkdownExtra::defaultTransform($news->getContent()));
        if ($special) return $this->render('special/new.html.twig',array('news'=>$news));
        return $this->render('news/show.html.twig',array('news'=>$news));
    }

    /**
     * @Route("/news", name="News",defaults={"special" = false})
     * @Route("/special/news", defaults={"special" = true})
     */
    public function newsAction(Request $request,$special)
    {
        $repository = $this->getDoctrine()->getRepository(News::class);
        $query = $repository->createQueryBuilder('p')
                // ->where('p.price > :price')
                // ->setParameter('price', '19.99')
                ->orderBy('p.publicationDate', 'DESC')
                ->getQuery();

        $news = $query->getResult();

        if (!$news) throw $this->createNotFoundException('Новость не найденна');
        if ($special) return $this->render('special/news.html.twig',array('news'=>$news));
        return $this->render('news/list.html.twig',array('news'=>$news));
    }

    /**
     * @Route("/admin/new/edd/{page}", name="EditNews", requirements={"page": "\d+"})
     */
    public function eddAction($page)
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('AppBundle:News')->find($page);
        if (!$news) throw $this->createNotFoundException('Новость не найденна');

        $form = $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $news = $form->getData();
                $em = $this->getDoctrine()->getManager();
                //$em->persist($news);
                $em->flush();

                return $this->redirectToRoute('News',array('message'=>'sНовость сохранена'));
            }
            return $this->redirectToRoute('News',array('message'=>'iОперация отменена'));
        }

        return $this->render('news/form2.html.twig',array('form' => $form->createView(),'news'=>$news));
    }

    /**
     * @Route("/admin/new/dell/{page}", name="DellNews", requirements={"page": "\d+"})
     */
    public function dellAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('AppBundle:News')->find($page);

        if (!$news) throw $this->createNotFoundException('Новость не найденна');

        $em->remove($news);
        $em->flush();
        return $this->redirectToRoute('News');
    }

    /**
     * @Route("/admin/new/add", name="AddNews")
     */
    public function addAction(Request $request)
    {

        $news = new News();

        $form = $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get('save')->isClicked()){
                $news = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();

                return $this->redirectToRoute('News',array('message'=>'sНовость сохранена'));
            }
            return $this->redirectToRoute('News',array('message'=>'iОперация отменена'));
        }

        return $this->render('news/form2.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin")
     */
    public function adminAction(Request $request)
    {
        $locale = $request->getLocale();
        $data=$this->container->getParameter('database_host');
        $path=$request->getPathInfo();
        return $this->render('admin/admin.html.twig',array('locale'=>$data,'path'=>$path));
    }

    private function storeFormValues(News &$entity,$data){
        if ( isset( $data['title'] ) ) $entity->setTitle($data['title']);
        if ( isset( $data['content'] ) ) $entity->setContent($data['content']);
        if ( isset( $data['summary'] ) ) $entity->setSummary($data['summary'] );
        if ( isset( $data['imageHref'] ) ) $entity->setImageHref($data['imageHref'] );
        if ( isset( $data['publicationDate'] ) ) 
            $entity->setPublicationDate(date_create($data['publicationDate']));
    }
}
