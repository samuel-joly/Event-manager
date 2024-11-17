<?php

namespace App\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
final class IsRoomFree extends Constraint
{
    public string $message = 'This room is currently used by slot "slot/{{ slot }}"';

    public function __construct(?string $message = null, ?array $groups = null, $payload = null, array $options = [])
    {
        parent::__construct($options, $groups, $payload);
        $this->message = $message ?? $this->message;
    }

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

    public function validatedBy(): string{
        return \App\Validator\IsRoomFreeValidator::class;
    }
}
