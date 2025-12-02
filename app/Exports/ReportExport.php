<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Enumerable;

class ReportExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(
        protected Enumerable $data,
        protected array $columns
    ) {}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return array_map(function($col) {
            return ucwords(str_replace('_', ' ', $col));
        }, $this->columns);
    }

    public function map($row): array
    {
        // If row is an object (Model), convert to array
        if (is_object($row) && method_exists($row, 'toArray')) {
            $row = $row->toArray();
        } elseif (is_object($row)) {
            $row = (array) $row;
        }

        // Return only requested columns in order
        return array_map(function($col) use ($row) {
            $value = $row[$col] ?? '';

            // Format JSON strings (e.g. metadata)
            if (is_string($value) && str_starts_with(trim($value), '{') && is_array($decoded = json_decode($value, true)) && (json_last_error() == JSON_ERROR_NONE)) {
                $formatted = [];
                foreach ($decoded as $k => $v) {
                    $formatted[] = "$k: " . (is_array($v) ? json_encode($v) : $v);
                }
                return implode("\n", $formatted); // Use newline for better readability in cells
            }

            return $value;
        }, $this->columns);
    }
}
