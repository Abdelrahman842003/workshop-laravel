<?php

namespace App\Services\Reporting\Exports\Strategies;

use App\Services\Reporting\Exports\Contracts\ExportStrategyInterface;

class ExcelExportStrategy implements ExportStrategyInterface
{
    /**
     * Export the given data.
     *
     * @param \App\Services\Reporting\DTOs\ReportDTO $report
     * @param string $filename
     * @return string
     */
    public function export(\App\Services\Reporting\DTOs\ReportDTO $report, string $filename): string
    {
        $firstItem = $report->data->first();
        $columns = $firstItem ? array_keys($firstItem instanceof \Illuminate\Database\Eloquent\Model ? $firstItem->toArray() : (array) $firstItem) : [];

        $export = new \App\Exports\ReportExport($report->data, $columns);
        
        \Maatwebsite\Excel\Facades\Excel::store($export, 'reports/' . $filename, 'public', \Maatwebsite\Excel\Excel::XLSX);

        return 'reports/' . $filename;
    }
}
