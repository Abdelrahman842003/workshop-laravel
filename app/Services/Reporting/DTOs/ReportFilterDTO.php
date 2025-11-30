<?php

namespace App\Services\Reporting\DTOs;

class ReportFilterDTO
{
    public function __construct(
        public string $reportType,
        public string $format,
        public ?string $startDate = null,
        public ?string $endDate = null,
        public array $columns = [],
        public array $filters = [],
        public ?int $templateId = null
    ) {}

    public static function fromRequest(array $data, string $type, string $format, ?int $templateId = null): self
    {
        return new self(
            reportType: $type,
            format: $format,
            startDate: $data['start_date'] ?? null,
            endDate: $data['end_date'] ?? null,
            columns: $data['columns'] ?? [],
            filters: $data['filters'] ?? [],
            templateId: $templateId
        );
    }
}
