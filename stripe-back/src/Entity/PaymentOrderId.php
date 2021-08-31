<?php

namespace App\Entity;

use App\Model\Shared\Domain\UuidValueObjectInterface;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping\{Embeddable, Column, Id};
use Ramsey\Uuid\Nonstandard\Uuid;

#[Embeddable]
final class PaymentOrderId implements UuidValueObjectInterface
{

    #[Id]
    #[Column(type: 'uuid', unique: true, name: 'id')]
    private UuidInterface $value;

    public function __construct(UuidInterface $value)
    {
        $this->value = $value;
    }

    public static function generate(): self
    {
        return new self(Uuid::uuid4());
    }

    public static function create(UuidInterface $value): self
    {
        return new self($value);
    }

    public static function fromString(string $value): self
    {
        return new self(Uuid::fromString($value));
    }

    public function getValue(): UuidInterface
    {
        return $this->value;
    }

    public function equals(PaymentOrderId $paymentOrderId): bool
    {
        return $this->value->equals($paymentOrderId->getValue());
    }

    public function equalsToValue(string $value): bool
    {
        return $this->value->equals(Uuid::fromString($value));
    }

    public function toString(): string
    {
        return $this->value->toString();
    }

    public function __toString()
    {
        return $this->value->toString();
    }
}
