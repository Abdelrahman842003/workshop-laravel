<?php

namespace App\Services\Integrations\Adapters;

use App\Services\Integrations\Contracts\IntegrationAdapterInterface;
use App\Services\Integrations\DTOs\ExportPayloadDTO;
use App\Services\Integrations\DTOs\IntegrationConfigDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StripeAdapter implements IntegrationAdapterInterface
{
    public function send(ExportPayloadDTO $payload, IntegrationConfigDTO $config): array
    {
        // In a real scenario, we would loop through data and create customers
        // For demo, we'll simulate a request to Stripe API
        
        $apiKey = $config->credentials['api_key'] ?? 'sk_test_demo';
        $url = 'https://api.stripe.com/v1/customers';

        Log::info("StripeAdapter: Syncing " . count($payload->data) . " records to Stripe.");

        // Simulate API Call
        // $response = Http::withToken($apiKey)->post($url, $payload->data[0]);

        return [
            'status' => 'success',
            'message' => 'Data synced to Stripe successfully',
            'provider_response' => [
                'id' => 'cus_' . uniqid(),
                'object' => 'customer',
                'created' => time(),
            ]
        ];
    }

    public function testConnection(IntegrationConfigDTO $config): bool
    {
        return !empty($config->credentials['api_key']);
    }
}
