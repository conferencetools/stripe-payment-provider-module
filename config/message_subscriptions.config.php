<?php
return [
    \ConferenceTools\Attendance\Domain\Payment\Event\PaymentMethodSelected::class => [
        \ConferenceTools\StripePaymentProvider\PaymentProvider\StripePaymentHandler::class,
    ],
    \ConferenceTools\StripePaymentProvider\Webhook\CreateWebhook::class => [
        \ConferenceTools\StripePaymentProvider\Webhook\CreateWebhookHandler::class,
    ],
];
