# Backend for processing Stripe Payment Intents

This is the backend for the demo project that shows how to process payment intents from Stripe.

## Installation

For running the project you will need the **docker-sync** library installed in your computer:

https://docker-sync.readthedocs.io/

After installing it, run `docker-sync-stack start` from `.docker` folder.

Then, connect to the `php` container:

`docker exec -it stripe-back_php_1 bash`

And run `composer install`. 

Finally, you have yo create a `env.local` file at the root of the project with the following content:

```
STRIPE_SECRET_KEY="YOUR SECRET KEY FROM STRIPE"
```

Then you are ready to go 🚀

## To listen Stripe events

Install Stripe CLI from  https://stripe.com/docs/stripe-cli and run from terminal:

```
stripe listen --forward-to http://test-domain.test/stripe/webhook
```

## Utilities

Being inside of the php container, you could run `composer check` from the root of the project to execute PhpCsFixer and PHPStan validations. 

