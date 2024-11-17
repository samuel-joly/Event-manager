<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\SlotFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SlotTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    public function testGet(): void
    {
        SlotFactory::createOne();
        static::createClient()->request('GET', '/slots');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/contexts/Slot',
            '@id' => '/slots',
        ]);
    }

    public function testPost(): void
    {
        $slot = SlotFactory::createOne();
        $event = $slot->event;
        $room = $slot->room;
        static::createClient()->request('POST', '/slots', ['headers' => ['Content-Type' => 'application/ld+json'], 'json' => [
            'room' => "/rooms/" . $room->getId(),
            'event' => "/events/" . $event->getId(),
            'name' => 'First Time Leader Path',
            'date' => '2024-11-27',
            'attendees' => 12,
            'startHour' => '08:00:00',
            'endHour' =>  '18:00:00',
            'roomConfiguration' => "U",
            'configurationSize' => 12,
            'configurationQuantity' => 1,
            'roomConfigurationPrecision' => '',
            'hostTable' => true,
            'paperboard' => 2,
            'chairSup' => 2,
            'tableSup' => 1,
            'pen' => false,
            'paper' => false,
            'scissors' => true,
            'scotch' => true,
            'postItXl' => 0,
            'paperA1' => false,
            'blocNote' => true,
            'gomette' => false,
            'pauseAM' => 12,
            'pausePM' => 12,
            'pauseAMContent' => '',
            'pausePMContent' => '',
            'meal' => 12,
            'morningCoffee' => 12,
            'afternoonCoffee' => 0,
            'coktail' => 0,
            'vegetarian' => 2,
            'glutenFree' => 1,
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@id' => '/slots/'.($slot->getId()+1),
            '@type' => 'Slot',
            'room' => '/rooms/'.($slot->getId()),
        ]);
    }

    /**
     */
    public function testCreateInvalidSlot(): void
    {
        $slots = SlotFactory::createMany(2);
        $event = $slots[0]->event;
        $room = $slots[0]->room;
        static::createClient()->request('POST', '/slots', ['headers' => ['Content-Type' => 'application/ld+json'], 'json' => [
            'room' => "/rooms/" . $room->getId(),
            'event' => "/events/" . $event->getId(),
            'name' => 'First Time Leader Path DUPLICATE',
            'date' => '2024-11-27',
            'attendees' => 12,
            'startHour' => '08:00:00',
            'endHour' =>  '18:00:00',
            'roomConfiguration' => "U",
            'configurationSize' => 12,
            'configurationQuantity' => 1,
            'roomConfigurationPrecision' => '',
            'hostTable' => true,
            'paperboard' => 2,
            'chairSup' => 2,
            'tableSup' => 1,
            'pen' => false,
            'paper' => false,
            'scissors' => true,
            'scotch' => true,
            'postItXl' => 0,
            'paperA1' => false,
            'blocNote' => true,
            'gomette' => false,
            'pauseAM' => 12,
            'pausePM' => 12,
            'pauseAMContent' => '',
            'pausePMContent' => '',
            'meal' => 12,
            'morningCoffee' => 12,
            'afternoonCoffee' => 0,
            'coktail' => 0,
            'vegetarian' => 2,
            'glutenFree' => 1,
        ]]);

        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@type' => 'Slot',
            'room' => '/rooms/'.($slots[0]->room->getId()),
            'event' => '/events/'.($slots[0]->event->getId()),
        ]);

        $event = $slots[1]->event;
        $room = $slots[0]->room;
        static::createClient()->request('POST', '/slots', ['headers' => ['Content-Type' => 'application/ld+json'], 'json' => [
            'room' => "/rooms/" . $room->getId(),
            'event' => "/events/" . $event->getId(),
            'name' => 'First Time Leader Path DUPLICATE',
            'date' => '2024-11-27',
            'attendees' => 12,
            'startHour' => '08:00:00',
            'endHour' =>  '18:00:00',
            'roomConfiguration' => "U",
            'configurationSize' => 12,
            'configurationQuantity' => 1,
            'roomConfigurationPrecision' => '',
            'hostTable' => true,
            'paperboard' => 2,
            'chairSup' => 2,
            'tableSup' => 1,
            'pen' => false,
            'paper' => false,
            'scissors' => true,
            'scotch' => true,
            'postItXl' => 0,
            'paperA1' => false,
            'blocNote' => true,
            'gomette' => false,
            'pauseAM' => 12,
            'pausePM' => 12,
            'pauseAMContent' => '',
            'pausePMContent' => '',
            'meal' => 12,
            'morningCoffee' => 12,
            'afternoonCoffee' => 0,
            'coktail' => 0,
            'vegetarian' => 2,
            'glutenFree' => 1,
        ]]);

        $this->assertResponseIsUnprocessable('This room is currently used by slot "slot/6"');
        $this->assertJsonContains([
            '@type' => 'ConstraintViolationList',
            'hydra:description' => 'This room is currently used by slot "slot/6"',
        ]);
    }
}
