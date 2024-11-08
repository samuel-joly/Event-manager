<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
class Event
{
    #[ORM\Column, ORM\Id, ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Slot::class)]
    #[Assert\NotNull]
    public ?iterable $slots = null;
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    public string $name = '';
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    public string $hostName = '';

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank, Assert\Email]
    public string $orgaMail = '';
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    public string $orgaTel = '';
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    public string $orgaName = '';

    public function __construct()
    {
        $this->slots = new ArrayCollection();
    }
    public function getId(): int
    {
        return $this->id;
    }
}
