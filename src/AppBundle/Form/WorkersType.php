<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class WorkersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichFileType::class, array('label' => 'Изображение'))
            ->add('name', TextType::class, array('label' => 'Имя'))
            ->add('description', TextareaType::class, array('label' => 'Должность и описание'))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }
}