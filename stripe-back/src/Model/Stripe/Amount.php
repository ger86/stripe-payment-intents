<?php

namespace App\Model\Stripe;

final class Amount
{
    private int $amount;
    private string $currency;

    public function __construct(int $amount, string $currency = 'eur')
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function fromFloat(float $amount, string $currency = 'eur'): self
    {
        $amountAsInteger = round($amount * 100);
        return new self(\intval($amountAsInteger), $currency);
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
