<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Constraints\IsRoomFree;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
#[IsRoomFree]
class Slot
{
    #[ORM\Column, ORM\Id, ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\ManyToOne(targetEntity: Room::class, cascade:['persist','remove'])]
    #[Assert\NotNull]
    public ?Room $room = null;
    #[Assert\NotNull]
    #[ORM\ManyToOne(targetEntity: Event::class, inversedBy:'slots', cascade:['persist','remove'])]
    public ?Event $event = null;
    #[ORM\Column(type: 'date')]
    #[Assert\NotNull]
    public ?\DateTime $date = null;
    #[ORM\Column(type: 'smallint')]
    #[Assert\NotNull]
    public ?int $attendees = null;
    #[ORM\Column]
    #[Assert\NotBlank]
    public string $startHour = '';
    #[ORM\Column]
    #[Assert\NotBlank]
    public string $endHour = '';
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank, Assert\NotNull]
    public ?string $roomConfiguration = null;
    #[ORM\Column(type: 'smallint')]
    #[Assert\NotNull, Assert\GreaterThan(0)]
    public ?int $configurationSize = null;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(1)]
    public ?int $configurationQuantity = null;

    #[ORM\Column(type: 'string')]
    public string $roomConfigurationPrecision = '';

    #[ORM\Column(type: 'boolean')]
    public bool $hostTable = true;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $paperboard = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $chairSup = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $tableSup = 0;

    #[ORM\Column(type: 'boolean')]
    public bool $pen = false;
    #[ORM\Column(type: 'boolean')]
    public bool $paper = false;
    #[ORM\Column(type: 'boolean')]
    public bool $scissors = false;
    #[ORM\Column(type: 'boolean')]
    public bool $scotch = false;
    #[ORM\Column(type: 'smallint')]
    public int $postItXl;
    #[ORM\Column(type: 'boolean')]
    public bool $paperA1 = false;
    #[ORM\Column(type: 'boolean')]
    public bool $blocNote = false;
    #[ORM\Column(type: 'boolean')]
    public bool $gomette = false;
    #[ORM\Column(type: 'boolean')]
    public bool $postIt = false;

    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $pauseAM = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $pausePM = 0;
    #[ORM\Column(type: 'string')]
    public string $pauseAMContent = '';
    #[ORM\Column(type: 'string')]
    public string $pausePMContent = '';
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $meal = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $morningCoffee = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $afternoonCoffee = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $coktail = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $vegetarian = 0;
    #[ORM\Column(type: 'smallint')]
    #[Assert\GreaterThanOrEqual(0)]
    public int $glutenFree = 0;
    #[ORM\Column(type: 'string')]
    public string $mealPrecision = '';

    public function getId(): int
    {
        return $this->id;
    }
    public function setRoom(Room $room):void {
        $this->room = $room;
    }
    public function setEvent(Event $event):void {
        $this->event = $event;
    }
}
