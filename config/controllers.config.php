<?php

use ConferenceTools\StripePaymentProvider\Controller;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'factories' => [
        Controller\WebhookController::class => InvokableFactory::class,
    ]
];
