<?php

namespace App\DataFixtures;

use App\Entity\Attack;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AttackFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 15; $i++) {
            $attack = new Attack();
            $attack->setName($faker->words(rand(1, 2), true));
            $cost = $faker->numberBetween(1, 20);
            $gain = $faker->numberBetween($cost, 4 * $cost);
            $successRate = (int)(($cost / $gain) * 100);
            $attack->setCost($cost);
            $attack->setGain($gain);
            $attack->setSuccessRate($successRate);

            $this->addReference("attack_" . $i, $attack);

            $manager->persist($attack);
        }

        $manager->flush();
    }
}
