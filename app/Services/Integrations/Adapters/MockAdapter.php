<?php

namespace App\Services\Integrations\Adapters;

use App\Services\Integrations\Contracts\IntegrationAdapterInterface;
use App\Services\Integrations\DTOs\ExportPayloadDTO;
use App\Services\Integrations\DTOs\IntegrationConfigDTO;
use Illuminate\Support\Facades\Log;

class MockAdapter implements IntegrationAdapterInterface
{
    public function send(ExportPayloadDTO $payload, IntegrationConfigDTO $config): array
    {
        // Simulate network delay
        sleep(1);

        Log::info("MockAdapter: Sending data to {$config->provider}", ['data' => $payload->data]);

        // Simulate success response
        return [
            'status' => 'success',
            'message' => 'Data received successfully by Mock System',
            'received_count' => count($payload->data),
            'timestamp' => now()->toIso8601String(),
        ];
    }

    public function testConnection(IntegrationConfigDTO $config): bool
    {
        return true;
    }
}
