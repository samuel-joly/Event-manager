<?php

namespace App\DataFixtures;

use App\Story\DefaultEventsStory;
use App\Story\DefaultRoomsStory;
use App\Story\DefaultSlotsStory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        DefaultEventsStory::load();
        DefaultRoomsStory::load();
        DefaultSlotsStory::load();
    }
}
