<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom de la formation',
            ])
            ->add('catalog_link', UrlType::class, [
                'required' => false,
                'label' => 'Lien du catalogue',
            ])
            ->add('eLearning_link', UrlType::class, [
                'required' => false,
                'label' => 'Lien e-Learning',
            ])
            ->add('is_active', CheckboxType::class, [
                'required' => false,
                'label' => 'Actif',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
