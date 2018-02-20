<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Yaml\Yaml;
use AppBundle\Entity\TextConfig;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Yaml\Exception\ParseException;

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
}