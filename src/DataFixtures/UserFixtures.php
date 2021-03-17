<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\ProfileRepository;
use DateTime;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends BaseFixtures implements DependentFixtureInterface
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var ProfileRepository
     */
    private $repository;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ProfileRepository $repository){
        $this->passwordEncoder = $passwordEncoder;
        $this->repository = $repository;
    }

    /**
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function loadData(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("utilisateur@gmail.com");
        $user->setPassword($this->passwordEncoder->encodePassword($user, "azerty"));
        $user->setFirstName("Maxime");
        $user->setLastName("DUROYON");
        $user->setPicture($this->faker->imageUrl($width = 70, $height = 70));
        $user->setProfile($this->repository->findAdminProfile());
        $user->setIsActive(true);
        $manager->persist($user);
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
