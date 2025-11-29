<?php

namespace App\Services\Reporting\Exports;

class ExportService
{
    public function __construct(
        protected \App\Services\Reporting\Exports\Strategies\CsvExportStrategy $csvStrategy,
        protected \App\Services\Reporting\Exports\Strategies\PdfExportStrategy $pdfStrategy,
        protected \App\Services\Reporting\Exports\Strategies\ExcelExportStrategy $excelStrategy
    ) {}

    /**
     * Export data in the specified format.
     *
     * @param \App\Services\Reporting\DTOs\ReportDTO $data
     * @param string $format
     * @return string
     */
    public function export($data, string $format): string
    {
        return match ($format) {
            'csv' => $this->csvStrategy->export($data),
            'pdf' => $this->pdfStrategy->export($data),
            'excel' => $this->excelStrategy->export($data),
            default => throw new \InvalidArgumentException("Unsupported format: $format"),
        };
    }
}
