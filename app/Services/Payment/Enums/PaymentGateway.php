<?php

namespace App\Services\Payment\Enums;

enum PaymentGateway: string
{
    case PAYPAL = '1';
    case STRIPE = '2';
    case BANK_TRANSFER = '3';
}
