<?php

namespace App\Services\Integrations\Mappers;

use App\Services\Integrations\Contracts\DataMapperInterface;
use Illuminate\Support\Collection;

class GenericMapper implements DataMapperInterface
{
    public function map(Collection $data, Collection $mappings): array
    {
        return $data->map(function ($item) use ($mappings) {
            $mappedItem = [];
            foreach ($mappings as $mapping) {
                // Get value from source (supports dot notation e.g. 'user.email')
                $value = data_get($item, $mapping->source_field);

                // Apply defaults
                if (is_null($value) && $mapping->default_value) {
                    $value = $mapping->default_value;
                }

                // Apply transformations
                if ($mapping->transformation) {
                    $value = $this->applyTransformation($value, $mapping->transformation);
                }

                $mappedItem[$mapping->target_field] = $value;
            }
            return $mappedItem;
        })->toArray();
    }

    protected function applyTransformation($value, string $rule)
    {
        if ($rule === 'uppercase') {
            return strtoupper($value);
        }

        if (str_starts_with($rule, 'date_format:')) {
            $format = substr($rule, 12);
            return $value ? \Carbon\Carbon::parse($value)->format($format) : null;
        }

        if (str_starts_with($rule, 'boolean:')) {
            // boolean:Yes|No
            $options = explode('|', substr($rule, 8));
            return $value ? ($options[0] ?? 'true') : ($options[1] ?? 'false');
        }

        if (str_starts_with($rule, 'static:')) {
            return substr($rule, 7);
        }

        return $value;
    }
}
