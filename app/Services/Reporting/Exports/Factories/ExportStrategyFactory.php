<?php

namespace App\Services\Reporting\Exports\Factories;

use App\Services\Reporting\Exports\Strategies\CsvExportStrategy;
use App\Services\Reporting\Exports\Strategies\ExcelExportStrategy;
use App\Services\Reporting\Exports\Strategies\PdfExportStrategy;
use InvalidArgumentException;

class ExportStrategyFactory
{
    public function __construct(
        protected CsvExportStrategy $csvStrategy,
        protected PdfExportStrategy $pdfStrategy,
        protected ExcelExportStrategy $excelStrategy
    ) {}

    public function create(string $format)
    {
        return match ($format) {
            'csv' => $this->csvStrategy,
            'pdf' => $this->pdfStrategy,
            'excel' => $this->excelStrategy,
            default => throw new InvalidArgumentException("Unsupported format: $format"),
        };
    }
}
