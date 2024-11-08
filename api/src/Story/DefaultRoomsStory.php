<?php

namespace App\Story;

use App\Tests\Factory\RoomFactory;
use Zenstruck\Foundry\Story;

final class DefaultRoomsStory extends Story
{
    public function build(): void
    {
        RoomFactory::createOne();
    }
}
