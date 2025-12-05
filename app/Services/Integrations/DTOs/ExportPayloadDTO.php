<?php

namespace App\Services\Integrations\DTOs;

class ExportPayloadDTO
{
    public function __construct(
        public array $data, // The transformed data
        public string $entityType = 'default' // e.g. 'users', 'orders'
    ) {}
}
