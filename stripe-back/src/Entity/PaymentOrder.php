<?php

namespace App\Entity;

use App\Model\PaymentOrder\PaymentOrderCreatedEvent;
use App\Model\PaymentOrder\PaymentOrderPaidEvent;
use App\Model\PaymentOrder\PaymentOrderAlreadyPaid;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\ORM\Mapping\{Embedded, Entity, Column, Id};
use Symfony\Contracts\EventDispatcher\Event as DomainEvent;

#[Entity(repositoryClass: 'App\Repository\PaymentOrderRepository')]
class PaymentOrder
{

    #[Embedded(class: PaymentOrderId::class, columnPrefix: false)]
    private PaymentOrderId $id;

    #[Embedded(class: Amount::class, columnPrefix: false)]
    private Amount $amount;

    #[Column(type: 'text')]
    private string $description;

    #[Column(type: 'datetime')]
    private DateTimeInterface $createdAt;

    #[Column(type: 'datetime')]
    private DateTimeInterface $updatedAt;

    #[Column(type: 'datetime', nullable: true)]
    private ?DateTimeInterface $paidAt;

    #[Embedded(class: Status::class, columnPrefix: false)]
    private Status $status;

    #[Embedded(class: StripePaymentIntent::class, columnPrefix: false)]
    private StripePaymentIntent $stripePaymentIntent;

    protected array $domainEvents = [];

    public function __construct(
        PaymentOrderId $id,
        Amount $amount,
        string $description,
        StripePaymentIntent $stripePaymentIntent
    ) {
        $this->id = $id;
        $this->amount = $amount;
        $this->description = $description;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->status = Status::pendingStatus();
        $this->stripePaymentIntent = $stripePaymentIntent;
        $this->paidAt = null;
    }

    public static function create(
        PaymentOrderId $id,
        Amount $amount,
        string $description,
        StripePaymentIntent $stripePaymentIntent
    ): self {
        $paymentOrder = new self($id, $amount, $description, $stripePaymentIntent);
        $event = new PaymentOrderCreatedEvent($id);
        $paymentOrder->recordDomainEvent($event);
        return $paymentOrder;
    }

    public function recordDomainEvent(DomainEvent $event): self
    {
        $this->domainEvents[] = $event;
        return $this;
    }

    /**
     * @return DomainEvent[]
     */
    public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];
        return $domainEvents;
    }

    public function getId(): PaymentOrderId
    {
        return $this->id;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getPaidAt(): ?DateTimeInterface
    {
        return $this->paidAt;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getStripePaymentIntent(): StripePaymentIntent
    {
        return $this->stripePaymentIntent;
    }

    public function updateStatus(Status $status): self
    {
        if ($status->isProcessing()) {
            return $this->markAsProcessing();
        }
        if ($status->isPaid()) {
            return $this->markAsPaid();
        }

        return $this;
    }

    public function markAsProcessing(): self
    {
        if ($this->status->isPending()) {
            $this->status = Status::processingStatus();
            $this->updatedAt = new DateTimeImmutable();
        }
        return $this;
    }

    public function markAsPaid(): self
    {
        if ($this->status->isPaid()) {
            throw new PaymentOrderAlreadyPaid($this->id);
        }
        $this->paidAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->status = Status::paidStatus();
        $event = new PaymentOrderPaidEvent($this->id);
        $this->recordDomainEvent($event);
        return $this;
    }
}
