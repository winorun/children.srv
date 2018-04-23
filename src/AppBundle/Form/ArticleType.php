<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Заголовок'))
            ->add('description', TextareaType::class, array('label' => 'Описание'))
            ->add('content', TextareaType::class, array('label' => 'Create Task','required' => false))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }
}