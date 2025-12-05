<?php

namespace App\Services\Integrations\Adapters;

use App\Services\Integrations\Contracts\IntegrationAdapterInterface;
use App\Services\Integrations\DTOs\ExportPayloadDTO;
use App\Services\Integrations\DTOs\IntegrationConfigDTO;
use Illuminate\Support\Facades\Log;

class PayPalAdapter implements IntegrationAdapterInterface
{
    public function send(ExportPayloadDTO $payload, IntegrationConfigDTO $config): array
    {
        // PayPal usually requires OAuth2 token exchange first
        // For demo, we simulate the final sync call
        
        $clientId = $config->credentials['client_id'] ?? 'demo_client';
        $secret = $config->credentials['client_secret'] ?? 'demo_secret';

        Log::info("PayPalAdapter: Syncing " . count($payload->data) . " records to PayPal.");

        return [
            'status' => 'success',
            'message' => 'Data synced to PayPal successfully',
            'provider_response' => [
                'status' => 'COMPLETED',
                'batch_id' => 'PAYPAL-' . uniqid(),
            ]
        ];
    }

    public function testConnection(IntegrationConfigDTO $config): bool
    {
        return !empty($config->credentials['client_id']) && !empty($config->credentials['client_secret']);
    }
}
