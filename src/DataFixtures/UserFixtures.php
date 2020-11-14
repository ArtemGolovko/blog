<?php


namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';
    public $faker;

    function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $user = new User(
            $this->faker->randomNumber(),
            $this->faker->email,
            $this->faker->userName,
            User::GOOGLE_OAUTH,
            [USER::ROLE_USER]
        );
        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_REFERENCE, $user);
    }


}