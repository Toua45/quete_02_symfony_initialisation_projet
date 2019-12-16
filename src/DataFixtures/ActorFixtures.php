<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Service\Slugify;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTOR = [
        'Andrew Lincoln',
        'Norman Reedus',
        'Lauren Cohan',
        'Danai Gurira',
    ];


    public function load(ObjectManager $manager)
    {

        $faker  =  Faker\Factory::create('fr_FR');
        for ($i = 0; $i <= 20; $i++) {
            $actor = new Actor();
            $slugify = new Slugify();
            $actor->setName($faker->name);
            $actor->addProgram($this->getReference('program_' . rand(1,5)));
            $actor->setSlug($slugify->generate($actor->getName()));
            $manager->persist($actor);
        }

        foreach (self::ACTOR as $key => $actorName) {
            $actor = new Actor();
            $slugify = new Slugify();
            $actor->setName($actorName);
            $actor->addProgram($this->getReference('program_0'));
            $this->addReference('actor_' . $key, $actor);
            $actor->setSlug($slugify->generate($actor->getName()));
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()

    {
        return [ProgramFixtures::class];
    }
}