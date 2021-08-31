<?php

namespace App\Model\PaymentOrder;

use App\Entity\PaymentOrderId;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The payment_order.paid event is dispatched each time a payment order is paid
 */
class PaymentOrderPaidEvent extends Event
{
    public const NAME = 'payment_order.paid';

    protected PaymentOrderId $id;

    public function __construct(PaymentOrderId $id)
    {
        $this->id = $id;
    }

    public function getId(): PaymentOrderId
    {
        return $this->id;
    }
}
