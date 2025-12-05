<?php

namespace App\Services\Payment\Services;

use App\Services\Payment\Contracts\PaymentGatewayInterface;
use App\Services\Payment\Enums\PaymentGateway;
use App\Services\Payment\Gateways\BankTransferPayment;
use App\Services\Payment\Gateways\PaypalPayment;
use App\Services\Payment\Gateways\StripePayment;
use Exception;

class PaymentService
{
    /**
     * @throws Exception
     */
    public function processPayment($data, $amount): array
    {
        $result = '';
        $gateway = $this->resolveGateway($data);
        $result .= $gateway->set_config();
        $pay_response = $gateway->pay($amount);

        $result .= '. ' .  $pay_response['message'];
        return [
            'success' => 1,
            'message' => $result
        ];
   }

    /**
     * @throws Exception
     */
    private function resolveGateway($data): PaymentGatewayInterface
    {
        $gateway = PaymentGateway::from($data['gateway']);
        return match ($gateway) {
            PaymentGateway::BANK_TRANSFER => new BankTransferPayment(),
            PaymentGateway::PAYPAL => new PaypalPayment(),
            PaymentGateway::STRIPE => new StripePayment(),
        };
    }

}
