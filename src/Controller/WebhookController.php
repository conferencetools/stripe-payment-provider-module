<?php

namespace ConferenceTools\StripePaymentProvider\Controller;

use ConferenceTools\Attendance\Domain\Payment\Command\ConfirmPayment;
use ConferenceTools\StripePaymentProvider\Webhook\CreateWebhook;
use ConferenceTools\StripePaymentProvider\Webhook\Webhook;
use ConferenceTools\StripePaymentProvider\Service\StripeSignatureValidator;
use Phactor\ReadModel\Repository;
use Phactor\Zend\ControllerPlugin\MessageBus;
use Zend\Form\Form;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ConferenceTools\StripePaymentProvider\Form\Webhook as WebhookForm;

/**
 * @method MessageBus messageBus()
 * @method Repository repository(string $className)
 * @method Form form($name, $options = [])
 */
class WebhookController extends AbstractActionController
{
    public function createAction()
    {
        $form = $this->form(WebhookForm::class);

        if ($this->getRequest()->isPost()) {
            $form->setData($this->params()->fromPost());
            if ($form->isValid()) {
                $data = $form->getData();

                $command = new CreateWebhook('stripe-payment-provider/webhooks/payment-intent-success', $data['url']);
                $this->messageBus()->fire($command);

                return $this->redirect()->toRoute('admin');
            }
        }

        $viewModel = new ViewModel(['form' => $form, 'action' => 'Create stripe webhook']);
        $viewModel->setTemplate('attendance/admin/form');
        return $viewModel;
    }

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