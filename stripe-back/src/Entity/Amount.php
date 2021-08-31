<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\{Embeddable, Column};

#[Embeddable]
final class Amount
{
    #[Column(name: 'value', type: 'float')]
    private float $value;

    #[Column(name: 'currency', type: 'string')]
    private string $currency;

    public function __construct(float $value, string $currency = 'eur')
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function toString(): string
    {
        return sprintf('%s %s', $this->value, $this->currency);
    }
}
