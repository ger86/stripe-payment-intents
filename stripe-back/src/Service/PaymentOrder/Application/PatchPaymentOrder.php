<?php

namespace App\Service\PaymentOrder\Application;

use App\Entity\PaymentOrderId;
use App\Entity\Status;
use App\Repository\PaymentOrderRepository;

class PatchPaymentOrder
{

    private GetPaymentOrder $getPaymentOrder;
    private PaymentOrderRepository $paymentOrderRepository;

    public function __construct(
        GetPaymentOrder $getPaymentOrder,
        PaymentOrderRepository $paymentOrderRepository
    ) {
        $this->getPaymentOrder = $getPaymentOrder;
        $this->paymentOrderRepository = $paymentOrderRepository;
    }

    public function __invoke(PaymentOrderId $id, int $statusValue): void
    {
        $paymentOrder = ($this->getPaymentOrder)($id);
        $status = new Status($statusValue);
        $paymentOrder->updateStatus($status);
        $this->paymentOrderRepository->save($paymentOrder);
        return;
    }
}
