<?php

namespace App\EventSubscriber\PaymentOrder;

use App\Model\Stripe\PaymentIntentSucceededReceivedFromWebhook;
use App\Repository\PaymentOrderRepository;
use App\Service\PaymentOrder\Application\MarkPaymentOrderAsPaid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PaymentIntentSucceededReceivedFromWebhookEventSubscriber implements EventSubscriberInterface
{
    private MarkPaymentOrderAsPaid $markPaymentOrderAsPaid;
    private PaymentOrderRepository $paymentOrderRepository;

    public function __construct(
        MarkPaymentOrderAsPaid $markPaymentOrderAsPaid,
        PaymentOrderRepository $paymentOrderRepository
    ) {
        $this->markPaymentOrderAsPaid = $markPaymentOrderAsPaid;
        $this->paymentOrderRepository = $paymentOrderRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            PaymentIntentSucceededReceivedFromWebhook::class => ['onPaymentIntentSucceeded']
        ];
    }

    public function onPaymentIntentSucceeded(PaymentIntentSucceededReceivedFromWebhook $event): void
    {
        $paymentIntent = $event->getPaymentIntent();
        $paymentOrder = $this->paymentOrderRepository->findOneBy([
            'stripePaymentIntent.paymentIntentId' => $paymentIntent->id
        ]);
        if ($paymentOrder === null) {
            return;
        }
        ($this->markPaymentOrderAsPaid)($paymentOrder->getId());
    }
}
