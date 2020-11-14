<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture  implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $this->loadPosts($manager);
    }

    private $faker;

    private $slug;

    public function __construct(Slugify $slugify)
    {
        $this->faker = Factory::create();
        $this->slug = $slugify;
    }

    public function loadPosts(ObjectManager $manager)
    {
        for ($i = 1; $i < 20; $i++) {
            $title = $this->faker->text(100);
            $post = Post::fromDraft(
                $this->getReference(UserFixtures::USER_REFERENCE),
                $title,
                $this->faker->text(1000),
                $this->slug->slugify($title)
            );
//            $post->setTitle($this->faker->text(100));
//            $post->setSlug($this->slug->slugify($post->getTitle()));
//            $post->setBody($this->faker->text(1000));
//            $post->setCreatedAt($this->faker->dateTime);

            $manager->persist($post);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
