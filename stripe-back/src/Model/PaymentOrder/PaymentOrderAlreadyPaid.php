<?php

declare(strict_types=1);

namespace App\Model\PaymentOrder;

use App\Entity\PaymentOrderId;
use App\Model\Shared\Domain\DomainException;

final class PaymentOrderAlreadyPaid extends DomainException
{

    public function __construct(PaymentOrderId $id)
    {
        parent::__construct(
            sprintf('The payment order <%s> is already paid', $id->toString())
        );
        $this->errorCode = 'payment_order_is_already_paid';
    }
}
