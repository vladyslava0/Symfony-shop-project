<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $items = [
            ['Laptop', 999.99, 3],
            ['Smartphone', 699.49, 10],
            ['Headphones', 129, 5],
            ['Keyboard', 59.99, 30],
            ['Mouse', 39.00, 45],
        ];

        foreach ($items as [$name, $price, $quantity]) {
            $item = new Item();
            $item->setName($name);
            $item->setPrice($price);
            $item->setQuantity($quantity);
            $manager->persist($item);
        }

        $manager->flush();
    }
}
