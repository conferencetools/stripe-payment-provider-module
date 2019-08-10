<?php

use Zend\Router\Http\Literal;
use Zend\Router\Http\Placeholder;
use Zend\Router\Http\Segment;

return [
    'stripe-payment-provider' => [
        'type' => Placeholder::class,
        'child_routes' => [
            'webhooks' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/webhooks',
                    'defaults' => [
                        'controller' => \ConferenceTools\StripePaymentProvider\Controller\WebhookController::class,
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'payment-intent-success' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/confirm-payment',
                            'defaults' => [
                                'action' => 'confirm-payment',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]
];