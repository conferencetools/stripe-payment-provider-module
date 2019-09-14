<?php

use Zend\Router\Http\Literal;
use Zend\Router\Http\Placeholder;

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
                    'admin' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/admin',
                            'defaults' => [
                                'requiresPermission' => 'stripe-config',
                                'layout' => 'admin/layout',
                            ]
                        ],
                        'may_terminate' => true,
                        'child_routes' => [
                            'create' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/create',
                                    'defaults' => [
                                        'action' => 'create',
                                        'controller' => \ConferenceTools\StripePaymentProvider\Controller\WebhookController::class,
                                    ],
                                ],
                            ],
                        ],
                    ],
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