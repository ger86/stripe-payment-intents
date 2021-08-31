<?php

namespace App\Model\PaymentOrder;

use App\Entity\PaymentOrderId;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The payment_order.created event is dispatched each time a payment order is created
 * in the system.
 */
class PaymentOrderCreatedEvent extends Event
{
    public const NAME = 'payment_order.created';

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
