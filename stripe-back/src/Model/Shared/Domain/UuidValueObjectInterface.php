<?php

namespace App\Model\Shared\Domain;

use Ramsey\Uuid\UuidInterface;

interface UuidValueObjectInterface extends ValueObjectInterface
{
    public function getValue(): ?UuidInterface;
}
