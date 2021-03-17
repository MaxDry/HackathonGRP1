<?php

namespace App\Form;

use App\Entity\TrainingManager;
use App\Entity\Team;
use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
            ->add('first_name')
            ->add('last_name')
            ->add('email')
            ->add('is_active')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TrainingManager::class,
        ]);
    }
}
