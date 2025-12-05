<?php

namespace App\Services\Integrations\Contracts;

use App\Services\Integrations\DTOs\ExportPayloadDTO;
use App\Services\Integrations\DTOs\IntegrationConfigDTO;

interface IntegrationAdapterInterface
{
    /**
     * Send data to the external system.
     *
     * @param ExportPayloadDTO $payload
     * @param IntegrationConfigDTO $config
     * @return array Response data (e.g. IDs of created records, or success message)
     * @throws \Exception If export fails
     */
    public function send(ExportPayloadDTO $payload, IntegrationConfigDTO $config): array;

    /**
     * Test the connection to the external system.
     *
     * @param IntegrationConfigDTO $config
     * @return bool
     */
    public function testConnection(IntegrationConfigDTO $config): bool;
}
