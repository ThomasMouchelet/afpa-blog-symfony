<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $hash = $this->passwordHasher->hashPassword($user, "password");

        $user
            ->setEmail("test@test.com")
            ->setPassword($hash);

        $manager->persist($user);

        $userADMIN = new User();
        $userADMIN
            ->setEmail("admin@test.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($hash);

        $manager->persist($userADMIN);

        $manager->flush();
    }
}
