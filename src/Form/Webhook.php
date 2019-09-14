<?php


namespace ConferenceTools\StripePaymentProvider\Form;


use Zend\Form\Element\Submit;
use Zend\Form\Element\Text;
use Zend\Form\Form;

class Webhook extends Form
{
    public function init()
    {
        $this->add([
            'type' => Text::class,
            'name' => 'url',
            'options' => [
                'label' => 'Base Url',
            ],
        ]);
        $this->add(new Submit('submit', ['label' => 'Create Webhook']));
    }
}