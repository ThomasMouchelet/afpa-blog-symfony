<?php

namespace App\DataFixtures;

use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=0; $i < 10; $i++) { 
            $post = new Post();
            $post
                ->setTitle("Titre $i")
                ->setContent("Content test $i")
                ->setCreatedAt(new DateTimeImmutable())
            ;

            $manager->persist($post);
        }

        $manager->flush();
    }
}
