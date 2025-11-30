<?php

namespace App\Services\Reporting\Exports;

class ExportService
{
    public function __construct(
        protected \App\Services\Reporting\Exports\Factories\ExportStrategyFactory $strategyFactory
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
        $strategy = $this->strategyFactory->create($format);
        $filename = 'report-' . now()->timestamp . '.' . ($format === 'excel' ? 'xlsx' : $format);
        return $strategy->export($data, $filename);
    }
}
