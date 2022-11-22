<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 15; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setNickname($faker->userName());
            $user->setScore($faker->numberBetween(1000, 15000));
            $user->setEmail($faker->email());
            $user->setPassword($this->hasher->hashPassword($user, "test"));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
