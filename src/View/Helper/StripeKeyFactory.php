<?php

namespace ConferenceTools\StripePaymentProvider\View\Helper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class StripeKeyFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        return new StripeKey($config['conferencetools']['payment_providers']['stripe']['publishable_key']);
    }
}
