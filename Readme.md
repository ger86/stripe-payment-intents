# Project for processing Stripe Payment Intents

This is a demo project that shows how to process Payment Intents from Stripe.

It's divided in two parts:

- A **backend project** developed with Symfony. This project allows to create Payment Intents in Stripe and receive webhook events. It also exposes a simple API to allow the frontend to fetch and create Payment Intents.

- A **frontend project** built with React that consummes the API of the backend in order to fetch, create and pay Payment Orders.

A **Payment Order** is the entity in the backend encapsulates the info of a Payment Intent from Stripe. You could see its properties in `./stripe-back/src/Entity/PaymentOrder.php` or in `./stripe-front/src/interfaces/index.ts`.

You could see the tutorial explaining the whole project at:

https://youtu.be/AUmpOVXFmOw

💛 Enjoy!

# ☕️ If you liked it, you can invite me for a coffee at:

https://www.buymeacoffee.com/latteandcode
