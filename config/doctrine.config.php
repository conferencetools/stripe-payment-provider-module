<?php
return [
    'driver' => [
        'stripe' => [
            'class' => \Doctrine\ORM\Mapping\Driver\AnnotationDriver::class,
            'cache' => 'array',
            'paths' => [__DIR__ . '/../src']
        ],
        'orm_default' => [
            'drivers' => [
                'ConferenceTools\\StripePaymentProvider' => 'stripe',
            ]
        ]
    ],
];
