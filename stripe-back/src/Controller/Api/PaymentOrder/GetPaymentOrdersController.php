<?php

namespace App\Controller\Api\PaymentOrder;

use App\Repository\PaymentOrderRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class GetPaymentOrdersController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(path="/payment-orders")
     */
    public function __invoke(
        PaymentOrderRepository $paymentOrderRepository
    ): View {
        $view = View::create($paymentOrderRepository->findBy([], ['createdAt' => 'DESC']));
        return $view;
    }
}
