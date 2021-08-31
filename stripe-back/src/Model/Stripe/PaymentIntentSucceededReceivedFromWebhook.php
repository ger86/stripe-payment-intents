<?php

namespace App\Model\Stripe;

use Stripe\PaymentIntent;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The stripe.payment_intent_succeeded_received_from_webhook event is dispatched each time webhook is invoked
 * with event payment_intent_succeeded
 */
class PaymentIntentSucceededReceivedFromWebhook extends Event
{
    public const NAME = 'stripe.payment_intent_succeeded_received_from_webhook';

    protected PaymentIntent $paymentIntent;

    public function __construct(PaymentIntent $paymentIntent)
    {
        $this->paymentIntent = $paymentIntent;
    }

    public function getPaymentIntent(): PaymentIntent
    {
        return $this->paymentIntent;
    }
}
