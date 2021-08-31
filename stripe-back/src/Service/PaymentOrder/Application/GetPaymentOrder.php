<?php

namespace App\Service\PaymentOrder\Application;

use App\Entity\PaymentOrder;
use App\Entity\PaymentOrderId;
use App\Model\PaymentOrder\PaymentOrderNotFound;
use App\Repository\PaymentOrderRepository;

class GetPaymentOrder
{

    private PaymentOrderRepository $repository;

    public function __construct(PaymentOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(PaymentOrderId $id): PaymentOrder
    {
        $paymentOrder = $this->repository->find($id);
        if ($paymentOrder === null) {
            throw new PaymentOrderNotFound($id);
        }
        return $paymentOrder;
    }
}
