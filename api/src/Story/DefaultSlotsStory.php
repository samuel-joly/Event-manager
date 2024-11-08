<?php

namespace App\Story;

use App\Tests\Factory\SlotFactory;
use Zenstruck\Foundry\Story;

final class DefaultSlotsStory extends Story
{
    public function build(): void
    {
        SlotFactory::createMany(20);
    }
}
