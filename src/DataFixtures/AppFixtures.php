<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
        // --> USER ADMIN
        $user = new User();
        $user
            ->setName('Sandrine')
            ->setLastname('Coupart')
            ->setBirth(new \DateTime('04/10/1972'))
            ->setEmail('sandrine.coupart@email.com')
            ->setPlainPassword('Adminadmin11')
            ->setRoles(['ROLE_ADMINISTRATOR'], ['ROLE_USER']);


        $manager->persist($user);

        $manager->flush();
    }
}
