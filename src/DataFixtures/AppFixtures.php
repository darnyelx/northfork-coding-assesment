<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    { for ($i = 0; $i < 20; $i++) {

        $product = new User();
        $product->setName('user  '.$i);
        $product->setUsername("username". mt_rand(10, 100));
        $product->setEmail("user". mt_rand(10, 100)."@email.com");
        $product->setPassword(password_hash("password", PASSWORD_ARGON2ID));

        $manager->persist($product);
    }

        $manager->flush();
    }
}
