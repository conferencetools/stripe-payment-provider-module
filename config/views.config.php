<?php
$viewDir = __DIR__ . '/../view/';
return [
    'stripe-payment-provider/purchase/stripe' => $viewDir . 'stripe.phtml',
    'stripe-payment-provider/purchase/stripe-webhook' => $viewDir . 'stripe-webhook.phtml',
];
