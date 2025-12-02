<?php

namespace App\Services\Integrations\Adapters;

use App\Services\Integrations\Contracts\IntegrationAdapterInterface;
use App\Services\Integrations\DTOs\ExportPayloadDTO;
use App\Services\Integrations\DTOs\IntegrationConfigDTO;
use Illuminate\Support\Facades\Http;

class SalesforceAdapter implements IntegrationAdapterInterface
{
    public function send(ExportPayloadDTO $payload, IntegrationConfigDTO $config): array
    {
        // In a real scenario, we would authenticate first using OAuth
        // For this workshop, we'll simulate a POST request if a URL is provided, or just mock it.
        
        $url = $config->settings['url'] ?? 'https://api.salesforce.com/services/data/v50.0/sobjects/Contact';
        
        // Simulate request
        // $response = Http::withToken($token)->post($url, $payload->data);
        
        // For demo purposes, we'll just return a success structure
        return [
            'id' => '003xxxxxxxxxxxxxxx',
            'success' => true,
            'errors' => []
        ];
    }

    public function testConnection(IntegrationConfigDTO $config): bool
    {
        return !empty($config->credentials['client_id']);
    }
}
