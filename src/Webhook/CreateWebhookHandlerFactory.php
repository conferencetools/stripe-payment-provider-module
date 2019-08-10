<?php

namespace ConferenceTools\StripePaymentProvider\Webhook;

use Cartalyst\Stripe\Stripe;
use Interop\Container\ContainerInterface;
use Phactor\Zend\RepositoryManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class CreateWebhookHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new CreateWebhookHandler(
            $container->get(Stripe::class),
            $container->get('Router'),
            $container->get(RepositoryManager::class)->get(Webhook::class)
        );
    }
}
