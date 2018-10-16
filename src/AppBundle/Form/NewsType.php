<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Заголовок:','attr'=>array('placeholder'=>'Имя страницы')))
            // ->add('imageHref', TextType::class, array('label' => 'Изображения:','attr'=>array('placeholder'=>'Изображения')))
            ->add('imageFile', VichImageType::class,  array('label' => 'Изображение:','required' => false))
            ->add('summary', TextareaType::class, array('label' => 'Анотация:','attr'=>array('placeholder'=>'Анотация','maxlength'=>'1000')))
            ->add('content', TextareaType::class, array('label' => false,'required' => false))
			->add('publicationDate', DateType::class, array('label' => 'Дата публикации:'))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }
}