<?php

namespace App\Form;

use App\Entity\TrainingManager;
use App\Entity\Team;
use App\Entity\City;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use App\Repository\TrainingManagerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingManagerType extends AbstractType
{
    private $trainingManagerRepo;

    public function __construct (TrainingManagerRepository $trainingManagerRepo) {
        $this->trainingManagerRepo = $trainingManagerRepo;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'required' => true,
                'label' => 'Prénom',
            ])
            ->add('last_name', TextType::class, [
                'required' => true,
                'label' => 'Nom',
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email',
            ])
            ->add('is_active', CheckboxType::class, [
                'required' => false,
                'label' => 'Actif',
            ])
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'label' => 'Équipe',
                'required' => false,
                'placeholder' => 'Aucun',
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'label' => 'Localisation',
                'required' => false,
                'placeholder' => 'Aucun',
            ])
            ->add('formations', EntityType::class, [
                'class' => Formation::class,
                'label' => 'Formations',
                'multiple' => true,
                'attr' => ['data-search' => 'Recherche'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrainingManager::class,
        ]);
    }
}
