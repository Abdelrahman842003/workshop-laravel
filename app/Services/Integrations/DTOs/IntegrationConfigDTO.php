<?php

namespace App\Services\Integrations\DTOs;

class IntegrationConfigDTO
{
    public function __construct(
        public array $credentials,
        public array $settings,
        public string $provider
    ) {}

    public static function fromModel($integration): self
    {
        return new self(
            credentials: $integration->credentials ?? [],
            settings: $integration->settings ?? [],
            provider: $integration->provider
        );
    }
}
