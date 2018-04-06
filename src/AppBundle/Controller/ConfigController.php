<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Yaml\Yaml;
use AppBundle\Entity\TextConfig;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Yaml\Exception\ParseException;

use AppBundle\Entity\Article;
use AppBundle\Entity\News;

use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class ConfigController extends Controller
{
    /**
     * @Route("/menu", name="formMenu")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(TextConfig::class);
        $text = $repository->findOneByName('menu');

        if (!$text) throw $this->createNotFoundException('Нас взламывают');//:)


		$yaml = Yaml::parse($text->getContent());

        $form = $this->createFormBuilder($text)
            ->add('content', TextareaType::class, array('label' => 'Файл','required' => false))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $text = $form->getData();

                try {
                    $yaml_test = Yaml::parse($text->getContent());
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    $this->addFlash('success', 'Изменение сохранены' );
                } catch (ParseException $e) {
                    $this->addFlash('danger', $e->getMessage() );
                }
        }
       return $this->render('menu/form.html.twig',array('form' => $form->createView(),'yaml_menu'=>$yaml));
    }

    /**
     * @Route("/footer", name="formFooter", defaults={"edit_param" = "footer"}))
     * @Route("/sitebar", name="formSitebar", defaults={"edit_param" = "sitebar"}))
     */
    public function footerAction(Request $request, $edit_param)
    {
        $repository = $this->getDoctrine()->getRepository(TextConfig::class);
        $text = $repository->findOneByName($edit_param);

        if (!$text) throw $this->createNotFoundException('Нас взламывают');//:)

        $form = $this->createFormBuilder($text)
            ->add('content', TextareaType::class, array('label' => 'Файл','required' => false))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->flush();
                $this->addFlash('success', 'Изменение сохранены' );
        }
       return $this->render('menu/form.html.twig',array('form' => $form->createView()));
    }

    /**
     * @Route("/sitemap.xml", defaults={"_format"="xml"}, name="Sitemap")
     */
    public function sitemapAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findAll();
        $news = $em->getRepository('AppBundle:News')->findAll();

        $response = new Response();
        $response->headers->set('Content-Type', 'xml');

        return $this->render('admin/sitemap.xml.twig',array('article'=>$article,'news'=>$news));
    }
}