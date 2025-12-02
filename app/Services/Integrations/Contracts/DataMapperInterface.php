<?php

namespace App\Services\Integrations\Contracts;

use Illuminate\Support\Collection;

interface DataMapperInterface
{
    /**
     * Map internal data to external format based on mapping rules.
     *
     * @param Collection $data Internal data (e.g. Users)
     * @param Collection $mappings Collection of IntegrationFieldMapping models
     * @return array Transformed data ready for export
     */
    public function map(Collection $data, Collection $mappings): array;
}
