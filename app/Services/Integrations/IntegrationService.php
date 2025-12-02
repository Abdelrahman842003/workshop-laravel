<?php

namespace App\Services\Integrations;

use App\Models\Integration;
use App\Services\Integrations\Contracts\DataMapperInterface;
use App\Services\Integrations\DTOs\ExportPayloadDTO;
use App\Services\Integrations\DTOs\IntegrationConfigDTO;
use App\Services\Integrations\Factories\AdapterFactory;
use App\Services\Integrations\Mappers\GenericMapper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class IntegrationService
{
    protected DataMapperInterface $mapper;

    public function __construct(DataMapperInterface $mapper = null)
    {
        $this->mapper = $mapper ?? new GenericMapper();
    }

    public function sync(Integration $integration, Collection $data)
    {
        $log = $integration->logs()->create([
            'status' => 'pending',
            'records_processed' => $data->count(),
            'occurred_at' => now(),
        ]);

        try {
            // 1. Prepare Config
            $configDTO = IntegrationConfigDTO::fromModel($integration);

            // 2. Map Data
            $mappedData = $this->mapper->map($data, $integration->fieldMappings);
            $payloadDTO = new ExportPayloadDTO($mappedData);

            // 3. Get Adapter
            $adapter = AdapterFactory::make($integration->provider);

            // 4. Send Data
            $response = $adapter->send($payloadDTO, $configDTO);

            // 5. Update Log Success
            $log->update([
                'status' => 'success',
                'payload_summary' => ['count' => count($mappedData), 'sample' => array_slice($mappedData, 0, 1)],
                'response_data' => $response,
            ]);

            $integration->update(['last_sync_at' => now()]);

            return $response;

        } catch (\Exception $e) {
            // 6. Update Log Failure
            $log->update([
                'status' => 'failed',
                'response_data' => ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()],
            ]);
            
            Log::error("Integration Sync Failed: {$e->getMessage()}");
            throw $e;
        }
    }
}
