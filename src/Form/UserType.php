<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Profile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        if($options['isEdit'] === false) {
            $builder
                ->add('email', EmailType::class, [
                    'required' => true,
                    'label' => 'Email',
                ])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmation du mot de passe'],
                    'invalid_message' => "password_no_match"
                ])
                ->add('first_name', TextType::class, [
                    'required' => true,
                    'label' => 'Prénom',
                ])
                ->add('last_name', TextType::class, [
                    'required' => true,
                    'label' => 'Nom',
                ])
                ->add('picture')
                ->add('is_active', CheckboxType::class, [
                    'required' => false,
                    'label' => 'Actif',
                ])
                ->add('profile', EntityType::class, [
                    'class' => Profile::class,
                    'label' => 'Profile',
                    'required' => false,
                    'placeholder' => 'Aucun',
                ])
            ;
        }
        $builder
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email',
            ])
            ->add('first_name', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
            ])
            ->add('last_name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('picture')
            ->add('is_active', CheckboxType::class, [
                'required' => false,
                'label' => 'Actif',
            ])
            ->add('profile', EntityType::class, [
                'class' => Profile::class,
                'label' => 'Profile',
                'required' => false,
                'placeholder' => 'Aucun',
            ])
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isEdit' => false,
        ]);
    }
}
