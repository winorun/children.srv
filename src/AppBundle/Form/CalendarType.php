<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CalendarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array('label' => 'Заголовок:','attr'=>array('placeholder'=>'Имя страницы')))
            ->add('type', TextareaType::class, array('label' => 'Форма мероприятия:','attr'=>array('placeholder'=>'Заседания клуба','maxlength'=>'1000')))
			->add('date', DateType::class, array('label' => 'Дата публикации:'))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }
}