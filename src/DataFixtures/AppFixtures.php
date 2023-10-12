<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\Recipes;
use App\Entity\Services;
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

        // --> USERS
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

        // --> RECIPES
        for($i = 1; $i < 20; $i ++) {
            $users = new Recipes();
            $users
                ->setName($this->faker->lastName())
                ->setPrepaTime(new \DateTime('01:30:00'))
                ->setCookingTime(new \DateTime('00:20:00'))
                ->setRestTime(new \DateTime('00:20:00'))
                ->setDiet([$this->faker->word(), $this->faker->word()])
                ->setAllergen([$this->faker->word(), $this->faker->word()])
                ->setDescription($this->faker->paragraph())
                ->setIngredient([$this->faker->word(), $this->faker->word()])
                ->setStage([$this->faker->word() => $this->faker->paragraph(), $this->faker->word() => $this->faker->paragraph()])
                ->setImages([$this->faker->word(), $this->faker->word()])
                ->setScore(0)
                ;
            $manager->persist($users);
        }

        // --> SERVICES
        for($i = 1; $i < 15; $i ++) {
            $services = new Services();
            $services
                ->setName($this->faker->word())
                ->setDescription($this->faker->paragraph())
                ;
            $manager->persist($services);
        }

        // --> CONTACTS
        for($i = 1; $i < 32; $i ++) {
            $services = new Contact();
            $services
            ->setName($this->faker->lastName())
            ->setLastname($this->faker->firstName())
            ->setEmail($this->faker->email())
            ->setSubject($this->faker->word())
            ->setText($this->faker->paragraph())
            ;
            $manager->persist($services);
        }



        $manager->flush();
    }
}
