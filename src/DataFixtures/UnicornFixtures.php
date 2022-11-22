<?php

namespace App\DataFixtures;

use App\Entity\Unicorn;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class UnicornFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 15; $i++) {
            $unicorn = new Unicorn();
            $unicorn->setName($faker->firstName('female'));
            $fights = $faker->numberBetween(1, 100);
            $wonFights = $faker->numberBetween(1, $fights);
            $lostFights = $fights - $wonFights;
            $koFights = $faker->numberBetween(0, $wonFights);
            $unicorn->setFights($fights);
            $unicorn->setWonFights($wonFights);
            $unicorn->setLostFights($lostFights);
            $unicorn->setKoFights($koFights);

            $attacksRefs = range(0, 14);
            shuffle($attacksRefs);
            for ($j = 0; $j < 3; $j++) {
                $unicorn->addAttack($this->getReference('attack_' . $attacksRefs[$i]));
            }

            $manager->persist($unicorn);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AttackFixtures::class
        ];
    }
}
