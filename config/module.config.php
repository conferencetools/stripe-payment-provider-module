<?php

return [
    'auth' => [
        'permissions' => [
            'stripe-config' => 'Stripe config',
        ]
    ],
    'controllers' => require __DIR__ . '/controllers.config.php',
    'conferencetools' => [
        'payment_providers' => [
            'stripe' => [
                'provider_service' => \ConferenceTools\StripePaymentProvider\PaymentProvider\StripePaymentProvider::class,
                'payment_type' => [
                    'name' => 'stripe',
                    'timeout' => 1800,
                    'manual_confirmation' => false,
                ],
                'secret_key' => '',
                'publishable_key' => '',
            ]
        ]
    ],
    'doctrine' => require __DIR__ . '/doctrine.config.php',
    'message_handlers' => require __DIR__ . '/message_handlers.config.php',
    'message_subscriptions' => require __DIR__ . '/message_subscriptions.config.php',
    'navigation' => [
        'default' =>
            [
                [
                    'label' => 'Stripe Webhook',
                    'route' => 'stripe-payment-provider/webhooks/admin/create',
                    'permission' => 'stripe-config'
                ]
            ]
    ],
    'router' => [
        'routes' => require __DIR__ . '/routes.config.php',
    ],
    'payment_providers' => [
        'factories' => [
            \ConferenceTools\StripePaymentProvider\PaymentProvider\StripePaymentProvider::class => \ConferenceTools\StripePaymentProvider\PaymentProvider\StripePaymentProviderFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            \Cartalyst\Stripe\Stripe::class => \ConferenceTools\StripePaymentProvider\Service\StripeFactory::class,
        ],
    ],
    'view_manager' => [
        'controller_map' => [
            'ConferenceTools\StripePaymentProvider\Controller' => 'stripe-payment-provider',
        ],
        'template_map' => require __DIR__ . '/views.config.php',
    ],
    'view_helpers' => [
        'factories' => [
            'stripeKey' => \ConferenceTools\StripePaymentProvider\View\Helper\StripeKeyFactory::class,
        ],
    ],
];