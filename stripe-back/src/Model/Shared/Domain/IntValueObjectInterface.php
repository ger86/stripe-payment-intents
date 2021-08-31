<?php

namespace App\Model\Shared\Domain;

interface IntValueObjectInterface extends ValueObjectInterface
{
    public function getValue(): ?int;
}
