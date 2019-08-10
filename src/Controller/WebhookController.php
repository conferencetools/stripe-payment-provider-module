<?php

namespace ConferenceTools\StripePaymentProvider\Controller;

use ConferenceTools\Attendance\Domain\Payment\Command\ConfirmPayment;
use ConferenceTools\StripePaymentProvider\Webhook\Webhook;
use ConferenceTools\StripePaymentProvider\Service\StripeSignatureValidator;
use Phactor\ReadModel\Repository;
use Phactor\Zend\ControllerPlugin\MessageBus;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * @method MessageBus messageBus()
 * @method Repository repository(string $className)
 */
class WebhookController extends AbstractActionController
{
    public function confirmPaymentAction()
    {
        //Called by stripe
        /** @var Request $request */
        $request = $this->getRequest();
        if (!($request instanceof Request)) {
            throw new \RuntimeException('Cannot call from console');
        }
        $payload = $request->getContent();
        $signature = $request->getHeader('STRIPE_SIGNATURE')->getFieldValue();

        $route = $this->getEvent()->getRouteMatch()->getMatchedRouteName();

        /** @var Webhook $webhook */
        $webhook = $this->repository(Webhook::class)->get($route);

        StripeSignatureValidator::verifyHeader($payload, $signature, $webhook->getSecret(), 300);
        $messages[] = 'Signature valid';

        $data = json_decode($payload, true);
        $messages[] = $data['type'];
        if ($data['type'] === 'payment_intent.succeeded') {
            $messages[] = $data['data']['object']['metadata'];
            if (isset($data['data']['object']['metadata']['paymentId'])) {
                $this->messageBus()->fire(new ConfirmPayment($data['data']['object']['metadata']['paymentId']));
            } // if it's not set we may have to fall back to loading the stripe payment to pull the payment id out.
        } // should we also deal with payment_intent.failed; trigger an error which prompts the user to enter details again?

        $viewModel = new ViewModel(['messages' => $messages]);
        $viewModel->setTemplate('attendance/purchase/stripe-webhook');
        $viewModel->setTerminal(true);

        return $viewModel;
    }
}