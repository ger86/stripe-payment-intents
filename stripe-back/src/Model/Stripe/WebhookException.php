<?php

namespace App\Model\Stripe;

use Exception;

class WebhookException extends Exception
{
    const ALLOWS_OK_RESPONSE = 1;
    const FORCES_KO_RESPONSE = 2;

    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}
