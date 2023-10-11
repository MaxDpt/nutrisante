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
            ->setRoles(['ROLE_ADMINISTRATOR', 'ROLE_USER']);
        $manager->persist($user);

        // --> USER ADMIN
        for($i = 1; $i < 20; $i ++) {
            $users = new User();
            $users
                ->setName($this->faker->lastName())
                ->setLastname($this->faker->firstName())
                ->setBirth(new \DateTime('04/10/1972'))
                ->setDiet([$this->faker->word(), $this->faker->word()])
                ->setAllergen([$this->faker->word(), $this->faker->word()])
                ->setEmail($this->faker->email())
                ->setPlainPassword('Password')
                ->setRoles(['ROLE_USER']);
            $manager->persist($users);
        }

        $manager->flush();
    }
}
