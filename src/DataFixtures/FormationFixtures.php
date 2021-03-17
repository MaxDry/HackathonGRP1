<?php

namespace App\DataFixtures;

use App\Entity\Formation;
use Doctrine\Persistence\ObjectManager;

class FormationFixtures extends BaseFixtures
{

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(20, "Formation", function ($count) {
            $formation = new Formation();
            $formation->setName("Formation ".$this->faker->word());
            $formation->setCatalogLink($this->faker->url());
            $formation->setELearningLink($this->faker->url());
            $formation->setIsActive($this->faker->boolean());

            return $formation;

        });

        $manager->flush();
    }
}
