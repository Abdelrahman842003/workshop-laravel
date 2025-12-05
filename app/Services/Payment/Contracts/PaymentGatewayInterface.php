<?php

namespace App\Services\Payment\Contracts;

interface PaymentGatewayInterface
{
    public function set_config(): string;
    public function pay($amount): array;

    public function refund($transaction_id): array;
}
