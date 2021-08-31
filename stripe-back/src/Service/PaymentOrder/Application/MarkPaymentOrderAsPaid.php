<?php

namespace App\Service\PaymentOrder\Application;

use App\Entity\PaymentOrderId;
use App\Repository\PaymentOrderRepository;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class MarkPaymentOrderAsPaid
{

    private GetPaymentOrder $getPaymentOrder;
    private PaymentOrderRepository $paymentOrderRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(
        GetPaymentOrder $getPaymentOrder,
        PaymentOrderRepository $paymentOrderRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->getPaymentOrder = $getPaymentOrder;
        $this->paymentOrderRepository = $paymentOrderRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(PaymentOrderId $id): void
    {
        $paymentOrder = ($this->getPaymentOrder)($id);
        $paymentOrder->markAsPaid();
        $this->paymentOrderRepository->save($paymentOrder);
        foreach ($paymentOrder->pullDomainEvents() as $domainEvent) {
            $this->eventDispatcher->dispatch($domainEvent);
        }
        return;
    }
}
