<?php

namespace ConferenceTools\StripePaymentProvider\PaymentProvider;

use ConferenceTools\Attendance\Domain\Payment\PaymentType;
use Interop\Container\ContainerInterface;
use Phactor\Zend\RepositoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class StripePaymentProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repositoryManager = $container->get(RepositoryManager::class);
        $config = $container->get('Config');
        $providerConfig = $config['conferencetools']['payment_providers']['stripe']['payment_type'];
        $paymentType = new PaymentType($providerConfig['name'], $providerConfig['timeout'], $providerConfig['manual_confirmation']);
        return new StripePaymentProvider($repositoryManager->get(StripePayment::class), $paymentType);
    }
}
