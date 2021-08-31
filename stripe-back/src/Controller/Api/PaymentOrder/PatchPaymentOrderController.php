<?php

namespace App\Controller\Api\PaymentOrder;

use App\Entity\PaymentOrderId;
use App\Service\PaymentOrder\Application\PatchPaymentOrder;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PatchPaymentOrderController extends AbstractFOSRestController
{
    /**
     * @Rest\Patch(path="/payment-orders/{id}")
     */
    public function __invoke(
        string $id,
        PatchPaymentOrder $patchPaymentOrder,
        Request $request
    ): View {
        $json = json_decode($request->getContent(), true);
        ($patchPaymentOrder)(
            PaymentOrderId::fromString($id),
            $json['status']
        );
        $view = View::create([], Response::HTTP_NO_CONTENT);
        return $view;
    }
}
