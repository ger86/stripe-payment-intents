<?php

namespace App\Entity;

use App\Model\Shared\Domain\IntValueObjectInterface;
use InvalidArgumentException;
use Doctrine\ORM\Mapping\{Embeddable, Column};

#[Embeddable]
final class Status implements IntValueObjectInterface
{

    #[Column(name: 'status', type: 'integer')]
    private int $value;

    const PENDING = 1;
    const PROCESSING = 2;
    const PAID = 3;

    public function __construct(int $value)
    {
        $this->ensureValidValue($value);
        $this->value = $value;
    }

    public static function getAll(): array
    {
        return [self::PENDING, self::PROCESSING, self::PAID];
    }

    public static function pendingStatus(): self
    {
        return new self(self::PENDING);
    }

    public static function processingStatus(): self
    {
        return new self(self::PROCESSING);
    }

    public static function paidStatus(): self
    {
        return new self(self::PAID);
    }

    public function isPending(): bool
    {
        return $this->value === self::PENDING;
    }

    public function isProcessing(): bool
    {
        return $this->value === self::PROCESSING;
    }

    public function isPaid(): bool
    {
        return $this->value === self::PAID;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function __toString()
    {
        return sprintf('%d', $this->value);
    }

    public function equals(Status $status): bool
    {
        return $this->value === $status->getValue();
    }

    public function ensureValidValue(int $value): void
    {
        if (!\in_array($value, self::getAll(), true)) {
            throw new InvalidArgumentException(sprintf('%d is not a valid status', $value));
        }
    }
}
