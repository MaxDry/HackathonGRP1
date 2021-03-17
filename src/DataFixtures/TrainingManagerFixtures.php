<?php

namespace App\DataFixtures;

use App\Entity\TrainingManager;
use Doctrine\Persistence\ObjectManager;

class TrainingManagerFixtures extends BaseFixtures
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, "TrainingManager", function ($count) {

            $trainingManager = new TrainingManager();
            $trainingManager->setEmail($this->faker->email());
            $trainingManager->setFirstName($this->faker->firstName());
            $trainingManager->setLastName($this->faker->lastName());
            $trainingManager->setIsActive($this->faker->boolean());

            return $trainingManager;

        });

        
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return [
            ProfileFixtures::class,
        ];
    }
}
