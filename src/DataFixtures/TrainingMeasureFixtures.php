<?php

namespace App\DataFixtures;

use App\Entity\TrainingMeasure;
use Doctrine\Persistence\ObjectManager;

class TrainingMeasureFixtures extends BaseFixtures
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadData(ObjectManager $manager)
    {
        $trainingMeasure = new TrainingMeasure();
        $trainingMeasure->setName('CPF');
        $trainingMeasure->setIsActive(true);
        $manager->persist($trainingMeasure);

        $trainingMeasure = new TrainingMeasure();
        $trainingMeasure->setName('CFP');
        $trainingMeasure->setIsActive(true);
        $manager->persist($trainingMeasure);

        $trainingMeasure = new TrainingMeasure();
        $trainingMeasure->setName('Préparation concours');
        $trainingMeasure->setIsActive(true);
        $manager->persist($trainingMeasure);

        $trainingMeasure = new TrainingMeasure();
        $trainingMeasure->setName('Parcours professionalisant');
        $trainingMeasure->setIsActive(true);
        $manager->persist($trainingMeasure);
        
        $manager->flush();
    }
}
