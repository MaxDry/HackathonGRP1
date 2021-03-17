<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use Doctrine\Persistence\ObjectManager;

class ProfileFixtures extends BaseFixtures
{
    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadData(ObjectManager $manager)
    {
        $allRoles = [];
        foreach (Profile::ROLES as $roles) {
            foreach ($roles as $role) {
                array_push($allRoles, $role);
            }
        }

        $profile = new Profile();
        $profile->setName('admin');
        $profile->setRoles($allRoles);
        $profile->setIsActive(true);
        $manager->persist($profile);

        $profile = new Profile();
        $profile->setName('Utilisateur');
        $profile->setRoles($allRoles);
        $profile->setIsActive(true);
        $manager->persist($profile);
        
        $manager->flush();
    }
}
