<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // créer 10 utilisateurs
        $users = [];
        for ($i=0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail($faker->email())
                ->setPassword($faker->password())
                ->setIsVerified($faker->boolean(true))
                ->setUsername($faker->userName())
                ->setAdress($faker->address())
                ->setBio($faker->text())
                ->setPicture($faker->image('public/images/fixtures', 640, 480, null, false))
                ->setBirthday($faker->dateTimeAD($max = 'now', $timezone = null));
            $manager->persist($user);
            $users[] = $user;
        }

        // créer 10 posts
        for ($i=0; $i < 10; $i++) {
            $post = new Post();
            $post
                ->setTitle($faker->title())
                ->setDescription($faker->text())
                ->setPicture($faker->image('public/images/fixtures', 640, 480, null, false))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', 'now')));

            // lier chaque post à un utilisateur aléatoire
            $randomUser = $faker->randomElement($users);
            $post->setCreatedBy($randomUser);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
