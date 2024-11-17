<?php

namespace App\Story;

use App\Factory\RoomFactory;
use Zenstruck\Foundry\Story;

final class DefaultRoomsStory extends Story
{
    public function build(): void
    {
        RoomFactory::createMany(11);
    }
}
