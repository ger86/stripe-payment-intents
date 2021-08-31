<?php

namespace App\Service\PaymentOrder\Application;

use App\Entity\PaymentOrder;
use App\Entity\PaymentOrderId;
use App\Entity\Amount as PaymentOrderAmount;
use App\Entity\StripePaymentIntent;
use App\Model\Stripe\Amount;
use App\Repository\PaymentOrderRepository;
use App\Service\Stripe\Api\PaymentIntentsApiClient;
use Exception;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CreatePaymentOrder
{
    private PaymentOrderRepository $repository;
    private EventDispatcherInterface $eventDispatcher;
    private PaymentIntentsApiClient $paymentIntentsApiClient;

    public function __construct(
        PaymentOrderRepository $repository,
        PaymentIntentsApiClient $paymentIntentsApiClient,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repository = $repository;
        $this->paymentIntentsApiClient = $paymentIntentsApiClient;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(
        float $amount,
        string $description,
        string $email
    ): PaymentOrder {

        // llamada a stripe
        $stripeAmount = Amount::fromFloat($amount);

        $paymentIntent = $this->paymentIntentsApiClient->create(
            $stripeAmount,
            $description,
            $email
        );

        if ($paymentIntent->client_secret === null) {
            throw new Exception('Cannot create payment intent at this moment');
        }

        // persistir en base de datos
        $id = PaymentOrderId::generate();

        $stripePaymentIntent = new StripePaymentIntent(
            $paymentIntent->id,
            $paymentIntent->client_secret
        );
        $paymentOrder = PaymentOrder::create(
            $id,
            new PaymentOrderAmount($amount),
            $description,
            $stripePaymentIntent
        );
        $this->repository->save($paymentOrder);
        foreach ($paymentOrder->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
        return $paymentOrder;
    }
}
