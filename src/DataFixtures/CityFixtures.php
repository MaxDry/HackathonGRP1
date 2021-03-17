<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Persistence\ObjectManager;

class CityFixtures extends BaseFixtures
{
    private $cities = [];

    public function __construct(){
        $this->cities = ['Toulon', 'Bordeaux', 'Rennes', 'SGL', 'SPAC', 'Metz', 'Lyon', 'DCC'];
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(count($this->cities), "City", function ($count) {
            $city = new City();
            $city->setName($this->cities[$count]);
            $city->setIsActive(true);
            
            return $city;
        });

        $manager->flush();
    }
}
