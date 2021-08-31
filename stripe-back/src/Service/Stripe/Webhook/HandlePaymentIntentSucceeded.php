<?php

namespace App\Service\Stripe\Webhook;

use App\Model\Stripe\PaymentIntentSucceededReceivedFromWebhook;
use App\Model\Stripe\WebhookException;
use Stripe\PaymentIntent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class HandlePaymentIntentSucceeded
{
    const EVENT = 'payment_intent.succeeded';

    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param PaymentIntent $paymentIntent
     * @return void
     * @throws WebhookException
     */
    public function __invoke(PaymentIntent $paymentIntent): void
    {
        $this->eventDispatcher->dispatch(new PaymentIntentSucceededReceivedFromWebhook($paymentIntent));
    }
}
