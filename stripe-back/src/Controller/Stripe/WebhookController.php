<?php

namespace App\Controller\Stripe;

use App\Service\Stripe\Webhook\HandleWebhookEvent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WebhookController extends AbstractController
{

    #[Route('/stripe/webhook', name: 'stripe_webhook', methods: ['POST'])]
    public function __invoke(Request $request, HandleWebhookEvent $handleWebhookEvent): Response
    {
        ($handleWebhookEvent)(json_decode($request->getContent(), true));
        return new Response('ok');
    }
}
