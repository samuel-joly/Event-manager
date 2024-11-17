<?php

namespace App\Story;

use App\Factory\EventFactory;
use App\Factory\RoomFactory;
use App\Factory\SlotFactory;
use Zenstruck\Foundry\Story;

final class DefaultSlotsStory extends Story
{
    public function build(): void
    {
        SlotFactory::createMany(
            90,
            function () {
                return [
                    'event' => EventFactory::randomOrCreate(),
                    'room' => RoomFactory::randomOrCreate()
                ];
            }
        );
    }
}
