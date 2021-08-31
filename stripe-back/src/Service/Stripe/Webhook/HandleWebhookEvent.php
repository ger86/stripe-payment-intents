<?php

namespace App\Service\Stripe\Webhook;

use App\Model\Stripe\WebhookException;
use Psr\Log\LoggerInterface;
use Stripe\Event;

class HandleWebhookEvent
{
    private array $handlers;
    private LoggerInterface $logger;

    public function __construct(
        HandlePaymentIntentSucceeded $handlePaymentIntentSucceeded,
        LoggerInterface $logger
    ) {
        $this->handlers[$handlePaymentIntentSucceeded::EVENT] = $handlePaymentIntentSucceeded;
        $this->logger = $logger;
    }

    /**
     * @param array $json
     * @return void
     * @throws WebhookException
     */
    public function __invoke(array $json): void
    {
        $event = Event::constructFrom($json);

        $handler = ($this->handlers[$event->type]) ?? null;
        if ($handler) {
            try {
                ($handler)($event->data->object);
            } catch (WebhookException $exception) {
                $this->logger->error($exception->getMessage());
                if ($exception->getCode() === WebhookException::FORCES_KO_RESPONSE) {
                    throw $exception;
                }
            }
        }
    }
}
