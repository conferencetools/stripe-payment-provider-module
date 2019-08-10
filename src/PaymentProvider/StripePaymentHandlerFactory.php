<?php

namespace ConferenceTools\StripePaymentProvider\PaymentProvider;

use Cartalyst\Stripe\Stripe;
use ConferenceTools\Attendance\Domain\Payment\ReadModel\Payment;
use Interop\Container\ContainerInterface;
use Phactor\Zend\RepositoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class StripePaymentHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $repositoryManager = $container->get(RepositoryManager::class);

        return new StripePaymentHandler(
            $repositoryManager->get(Payment::class),
            $repositoryManager->get(StripePayment::class),
            $container->get(Stripe::class)
        );
    }
}