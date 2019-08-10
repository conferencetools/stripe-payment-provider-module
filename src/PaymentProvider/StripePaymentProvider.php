<?php

namespace ConferenceTools\StripePaymentProvider\PaymentProvider;

use Cartalyst\Stripe\Stripe as StripeClient;
use ConferenceTools\Attendance\Domain\Payment\Event\PaymentMethodSelected;
use ConferenceTools\Attendance\Domain\Payment\ReadModel\Payment;
use ConferenceTools\Attendance\Domain\Purchasing\ReadModel\Purchase;
use ConferenceTools\Attendance\PaymentProvider\PaymentProvider;
use Phactor\Message\DomainMessage;
use Phactor\ReadModel\Repository;
use Zend\View\Model\ViewModel;

class StripePaymentProvider implements PaymentProvider
{
    private $stripePaymentRepository;

    public function __construct(Repository $stripePaymentRepository)
    {
        $this->stripePaymentRepository = $stripePaymentRepository;
    }

    public function getView(Purchase $purchase, Payment $payment): ViewModel
    {
        $stripePayment = $this->stripePaymentRepository->get($payment->getId());

        $viewModel = new ViewModel(['purchase' => $purchase, 'payment' => $payment, 'stripePayment' => $stripePayment]);
        $viewModel->setTemplate('stripe-payment-provider/payment');
        return $viewModel;
    }
}