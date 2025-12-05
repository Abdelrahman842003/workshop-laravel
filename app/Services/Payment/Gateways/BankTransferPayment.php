<?php

namespace App\Services\Payment\Gateways;

use App\Services\Payment\Contracts\PaymentGatewayInterface;

class BankTransferPayment implements PaymentGatewayInterface
{
    private $IBAN;
    private $password;


    public function set_config(): string
    {
        return 'set config data for bank transfer';

    }

    public function pay($amount): array
    {
        return [
            'success' => 1,
            'message' => "handle bank transfer payment: " . $amount,
        ];
    }

    public function refund($transaction_id): array
    {
        return [
            'success' => 1,
            'message' => "Handle bank transfer refund: " . $transaction_id,
        ];
    }
}
