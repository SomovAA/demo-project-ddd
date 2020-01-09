<?php

namespace Fixtures;

use Application\Entity\Product\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixture implements FixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 20; $i++) {
            $product = new Product($faker->sentence, $faker->randomFloat(0, 1, 10));
            $manager->persist($product);
        }
        $manager->flush();
    }
}