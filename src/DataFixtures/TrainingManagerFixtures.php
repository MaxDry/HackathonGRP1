<?php

namespace App\DataFixtures;

use App\Entity\TrainingManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class TrainingManagerFixtures extends BaseFixtures implements DependentFixtureInterface
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
            $trainingManager->setCity($this->getRandomReference("City"));
            $trainingManager->setTeam($this->getRandomReference("Team"));
            $trainingManager->addFormation($this->getRandomReference("Formation"));

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
            FormationFixtures::class,
            CityFixtures::class,
            TeamFixtures::class,
        ];
    }
}
