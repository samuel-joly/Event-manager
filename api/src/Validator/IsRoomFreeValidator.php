<?php

namespace App\Validator;

use App\Constraints\IsRoomFree;
use App\Entity\Slot;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class IsRoomFreeValidator extends ConstraintValidator
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof Slot) {
            throw new UnexpectedTypeException($value, Slot::class);
        }

        if (!$constraint instanceof IsRoomFree) {
            throw new UnexpectedTypeException($constraint, IsRoomFree::class);
        }

        $occupant = $this->entityManager->getRepository(Slot::class)->createQueryBuilder('e')
            ->where('e.room = :room')
            ->andWhere('e.date = :date')
            ->setParameter('room', $value->room)
            ->setParameter('date', $value->date)
            ->getQuery()
            ->getResult();

        if (count($occupant) == 1) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ slot }}', $occupant[0]->getId())
                ->addViolation();
        }
    }
}
