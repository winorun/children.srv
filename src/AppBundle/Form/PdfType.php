<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Vich\UploaderBundle\Form\Type\VichFileType;

class PdfType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Имя Файла'))
            ->add('pdf', VichFileType::class, array('label' => 'Файл'))
            ->add('save', SubmitType::class, array('label' => 'Сохранить'))
        ;
    }
}