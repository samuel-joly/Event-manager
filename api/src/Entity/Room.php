<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
class Room
{
    #[ORM\Column, ORM\Id, ORM\GeneratedValue]
    private ?int $id = null;
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    public string $name = '';

    public function getId(): int
    {
        return $this->id;
    }
}
