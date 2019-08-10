<?php

namespace ConferenceTools\StripePaymentProvider\PaymentProvider;

use Interop\Container\ContainerInterface;
use Phactor\Zend\RepositoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class StripePaymentProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repositoryManager = $container->get(RepositoryManager::class);
        return new StripePaymentProvider($repositoryManager->get(StripePayment::class));
    }
}
