<?php

namespace App\Services\Gateways;

use Omnipay\Omnipay;

class Mollie
{
    public $company;

    /**
     * Mollie Construct.
     *
     * @param mixed $company
     * @param mixed $saas
     */
    public function __construct($company, $saas = false)
    {
        $this->saas = $saas;
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function gateway()
    {
        $gateway = Omnipay::create('Mollie');

        // If saas
        if ($this->saas) {
            $gateway->setApiKey(get_system_setting('mollie_api_key'));

            return $gateway;
        }

        $gateway->setApiKey($this->company->getSetting('mollie_api_key'));

        return $gateway;
    }

    /**
     * @param array $parameters
     *
     * @return mixed
     */
    public function purchase(array $parameters)
    {
        return $this->gateway()
            ->purchase($parameters)
            ->send();
    }

    /**
     * @param array $parameters
     */
    public function complete(array $parameters)
    {
        return $this->gateway()
            ->completePurchase($parameters)
            ->send();
    }

    /**
     * @param $amount
     */
    public function formatAmount($amount)
    {
        return number_format($amount / 100, 2, '.', '');
    }

    /**
     * @param $invoice
     */
    public function getNotifyUrl($invoice)
    {
        return route('customer_portal.invoices.mollie.webhook', [
            'customer' => $invoice->customer->uid,
            'invoice' => $invoice->uid,
        ]);
    }

    /**
     * @param $invoice
     */
    public function getReturnUrl($invoice)
    {
        return route('customer_portal.invoices.mollie.completed', [
            'customer' => $invoice->customer->uid,
            'invoice' => $invoice->uid,
        ]);
    }
}
