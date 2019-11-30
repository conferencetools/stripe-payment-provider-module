<?php

namespace ConferenceTools\StripePaymentProvider\Service;

use Cartalyst\Stripe\Stripe;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class StripeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        Stripe::disableAmountConverter();
        return Stripe::make($config['conferencetools']['payment_providers']['stripe']['secret_key']);
    }
}