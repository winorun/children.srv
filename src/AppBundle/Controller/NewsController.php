<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\News;
use Doctrine\ORM\EntityManagerInterface;

class NewsController extends Controller
{


    public function recentNewsAction($max = 6){

        $repository = $this->getDoctrine()->getRepository(News::class);
        $query = $repository->createQueryBuilder('p')
                // ->where('p.price > :price')
                // ->setParameter('price', '19.99')
                ->orderBy('p.publicationDate', 'DESC')
                ->setMaxResults( $max )
                ->getQuery();

        $news = $query->getResult();
        // $news = $query->setMaxResults(1)->getOneOrNullResult();

        if (!$news) throw $this->createNotFoundException('Новость не найденна');

        return $this->render(
            'news/recent_list_news.html.twig',
            array('news' => $news)
        );
    }

    /**
     * @Route("/news", name="News")
     */
    public function newsAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(News::class);
        $query = $repository->createQueryBuilder('p')
                // ->where('p.price > :price')
                // ->setParameter('price', '19.99')
                ->orderBy('p.publicationDate', 'DESC')
                ->getQuery();

        $news = $query->getResult();

        if (!$news) throw $this->createNotFoundException('Новость не найденна');

        return $this->render('news/list.html.twig',array('news'=>$news));
    }

    /**
     * @Route("/news/{page}", name="ShowNews", requirements={"page": "\d+"})
     */
    public function showAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('AppBundle:News')->find($page);

        if (!$news) throw $this->createNotFoundException('Новость не найденна');

        return $this->render('news/show.html.twig',array('news'=>$news));
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

        if($request->request->has("saveChanges")){
            $this->storeFormValues($news,$request->request->all());
            $em->flush();
            return $this->redirectToRoute('News',array('message'=>'sНовость сохранена'));
        }
        if($request->request->has("cancel")){
            return $this->redirectToRoute('News',array('message'=>'iОперация отменена'));
        }
        return $this->render('news/form.html.twig',array('news'=>$news));
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
        if($request->request->has("saveChanges")){
            $news = new News();

            $this->storeFormValues($news,$request->request->all());

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            return $this->redirectToRoute('News',array('message'=>'sНовость сохранена'));
        }
        if($request->request->has("cancel")){
            return $this->redirectToRoute('News',array('message'=>'iОперация отменена'));
        }          
        $path=$request->getPathInfo();
        return $this->render('news/form.html.twig',array('path'=>$path,'title'=>'Добавить новость'));
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
        if ( isset( $data['publicationDate'] ) ) $entity->setPublicationDate(date_create($data['publicationDate']));
    }
}
