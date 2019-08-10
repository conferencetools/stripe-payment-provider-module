<?php

return [
    'factories' => [
        \ConferenceTools\StripePaymentProvider\PaymentProvider\StripePaymentHandler::class => \ConferenceTools\StripePaymentProvider\PaymentProvider\StripePaymentHandlerFactory::class,
        \ConferenceTools\StripePaymentProvider\Webhook\CreateWebhookHandler::class => \ConferenceTools\StripePaymentProvider\Webhook\CreateWebhookHandlerFactory::class,
    ]
];