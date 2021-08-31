<?php

namespace App\Controller\Api\PaymentOrder;

use App\Service\PaymentOrder\Application\CreatePaymentOrder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\{Request, Response};

class PostPaymentOrderController extends AbstractFOSRestController
{
    /**
     * @Rest\Post(path="/payment-orders")
     */
    public function __invoke(
        Request $request,
        CreatePaymentOrder $createPaymentOrder
    ): View {
        $json = json_decode($request->getContent(), true);
        $paymentOrder = ($createPaymentOrder)(
            $json['amount'],
            $json['description'],
            $json['email']
        );

        $view = View::create($paymentOrder);
        return $view;
    }
}
