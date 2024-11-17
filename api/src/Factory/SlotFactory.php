<?php

namespace App\Factory;

use App\Entity\Slot;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;
use function Zenstruck\Foundry\lazy;

/**
 * @extends PersistentProxyObjectFactory<Slot>
 */
final class SlotFactory extends PersistentProxyObjectFactory
{
    public function __construct() {}

    public static function class(): string
    {
        return Slot::class;
    }

    protected function defaults(): array|callable
    {
        $attendees = self::faker()->numberBetween(5, 18);
        return [
            'event' => lazy(fn() => EventFactory::createOne()),
            'room' => lazy(fn() => RoomFactory::createOne()),
            'afternoonCoffee' => self::faker()->numberBetween(0, $attendees),
            'attendees' => $attendees,
            'blocNote' => self::faker()->boolean(),
            'chairSup' => self::faker()->numberBetween(1, 5),
            'coktail' => self::faker()->numberBetween(1, $attendees),
            'configurationQuantity' => self::faker()->numberBetween(0, 4),
            'configurationSize' => self::faker()->numberBetween(1, $attendees),
            'date' => new \DateTime("2024-1-" . rand(1, 17)),
            'endHour' => self::faker()->time(),
            'glutenFree' => self::faker()->numberBetween(0, $attendees),
            'gomette' => self::faker()->boolean(),
            'hostTable' => self::faker()->boolean(),
            'meal' => self::faker()->numberBetween(0, $attendees),
            'mealPrecision' => self::faker()->text(),
            'morningCoffee' => self::faker()->numberBetween(1, $attendees),
            'paper' => self::faker()->boolean(),
            'paperA1' => self::faker()->boolean(),
            'paperboard' => self::faker()->numberBetween(0, 6),
            'pauseAM' => self::faker()->numberBetween(0, $attendees),
            'pauseAMContent' => self::faker()->text(),
            'pausePM' => self::faker()->numberBetween(0, $attendees),
            'pausePMContent' => self::faker()->text(),
            'pen' => self::faker()->boolean(),
            'postIt' => self::faker()->boolean(),
            'postItXl' => self::faker()->numberBetween(1, 4),
            'roomConfiguration' => self::faker()->text(),
            'roomConfigurationPrecision' => self::faker()->text(),
            'scissors' => self::faker()->boolean(),
            'scotch' => self::faker()->boolean(),
            'startHour' => self::faker()->time(),
            'tableSup' => self::faker()->numberBetween(1, 4),
            'vegetarian' => self::faker()->numberBetween(1, $attendees),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Slot $slot): void {})
        ;
    }
}
