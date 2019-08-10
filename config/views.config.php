<?php
$viewDir = __DIR__ . '/../view/';
return [
    'stripe-payment-provider/payment' => $viewDir . 'stripe.phtml',
    'stripe-payment-provider/webhook/confirm-payment' => $viewDir . 'stripe-webhook.phtml',
];
