<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends BaseFixtures
{
    private $teams = [];

    public function __construct(){
        $this->teams = ['SRHC', 'CMG'];
    }
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(count($this->teams), "Team", function ($count) {
            $team = new Team();
            $team->setName($this->teams[$count]);
            $team->setPicture($this->faker->imageUrl($width = 70, $height = 70));
            $team->setIsActive(true);
            
            return $team;
        });

        $manager->flush();
    }
}
