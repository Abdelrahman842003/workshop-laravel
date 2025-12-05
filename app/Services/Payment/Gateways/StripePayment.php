<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\PaymentGatewayInterface;

class StripePayment implements PaymentGatewayInterface
{
    private $public_key;
    private $secret_key;

    public function set_config(): string
    {
        return 'set config data for stripe';
    }

    public function pay($amount): array
    {
        return [
            'success' => 1,
            'message' => "handle stripe payment: " . $amount,
        ];
    }

    public function refund($transaction_id): array
    {
        return [
            'success' => 1,
            'message' => "Handle Paypal refund: " . $transaction_id,
        ];
    }
}
