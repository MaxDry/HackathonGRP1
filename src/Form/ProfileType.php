<?php

namespace App\Form;

use App\Entity\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('is_active', CheckboxType::class, [
                'required' => false,
                'label' => 'Actif',
            ])
        ;

        foreach (Profile::ROLES as $roles) {
            foreach ($roles as $role) {
                $builder->add($role, CheckboxType::class, [
                    'label' => $role,
                    'mapped' => false,
                    'required' => false,
                    'data' => in_array($role,$options['data']->getRoles())
                ]);
            }
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}
