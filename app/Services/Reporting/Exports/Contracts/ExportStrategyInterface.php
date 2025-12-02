<?php

namespace App\Services\Reporting\Exports\Contracts;

interface ExportStrategyInterface
{
    /**
     * Export the given data.
     *
     * @param mixed $data
     * @return mixed
     */
    public function export(\App\Services\Reporting\DTOs\ReportDTO $report, string $filename): string;
}
