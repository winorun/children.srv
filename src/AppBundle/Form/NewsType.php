<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Заголовок','attr'=>array('placeholder'=>'Имя страницы')))
            ->add('imageHref', TextType::class, array('label' => 'Заголовок'))
            ->add('summary', TextareaType::class, array('label' => 'Описание'))
            ->add('content', TextareaType::class, array('label' => 'Create Task','required' => false))
			->add('publicationDate', DateType::class, array('label' => 'Описание'))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }
}