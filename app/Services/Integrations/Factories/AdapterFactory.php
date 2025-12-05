<?php

namespace App\Services\Integrations\Factories;

use App\Services\Integrations\Adapters\SalesforceAdapter;
use App\Services\Integrations\Adapters\MockAdapter;
use App\Services\Integrations\Contracts\IntegrationAdapterInterface;
use InvalidArgumentException;

class AdapterFactory
{
    public static function make(string $provider): IntegrationAdapterInterface
    {
        return match ($provider) {
            'salesforce' => new SalesforceAdapter(),
            'sap' => new \App\Services\Integrations\Adapters\SapAdapter(),
            'stripe' => new \App\Services\Integrations\Adapters\StripeAdapter(),
            'paypal' => new \App\Services\Integrations\Adapters\PayPalAdapter(),
            'webhook', 'mock' => new MockAdapter(),
            default => throw new InvalidArgumentException("Unsupported provider: {$provider}"),
        };
    }
}
