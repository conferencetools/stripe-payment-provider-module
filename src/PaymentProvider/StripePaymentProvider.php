<?php

namespace ConferenceTools\StripePaymentProvider\PaymentProvider;

use ConferenceTools\Attendance\Domain\Payment\Event\PaymentMethodSelected;
use ConferenceTools\Attendance\Domain\Payment\ReadModel\Payment;
use ConferenceTools\Attendance\Domain\Purchasing\ReadModel\Purchase;
use ConferenceTools\Attendance\PaymentProvider\PaymentProvider;
use ConferenceTools\Attendance\Domain\Payment\PaymentType;
use Phactor\ReadModel\Repository;
use Zend\View\Model\ViewModel;

class StripePaymentProvider implements PaymentProvider
{
    private $stripePaymentRepository;
    private $paymentType;

    public function __construct(Repository $stripePaymentRepository, PaymentType $paymentType)
    {
        $this->stripePaymentRepository = $stripePaymentRepository;
        $this->paymentType = $paymentType;
    }

    public function getView(Purchase $purchase, Payment $payment): ViewModel
    {
        $stripePayment = $this->stripePaymentRepository->get($payment->getId());

        $viewModel = new ViewModel(['purchase' => $purchase, 'payment' => $payment, 'stripePayment' => $stripePayment, 'paymentType' => $this->paymentType]);
        $viewModel->setTemplate('stripe-payment-provider/payment');
        return $viewModel;
    }
}