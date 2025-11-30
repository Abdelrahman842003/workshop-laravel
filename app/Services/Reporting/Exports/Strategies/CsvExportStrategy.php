<?php

namespace App\Services\Reporting\Exports\Strategies;

use App\Services\Reporting\Exports\Contracts\ExportStrategyInterface;

class CsvExportStrategy implements ExportStrategyInterface
{
    /**
     * Export the given data.
     *
     * @param mixed $data
     * @return mixed
     */
    public function export(\App\Services\Reporting\DTOs\ReportDTO $report, string $filename): string
    {
        $firstItem = $report->data->first();
        $columns = $firstItem ? array_keys($firstItem instanceof \Illuminate\Database\Eloquent\Model ? $firstItem->toArray() : (array) $firstItem) : [];

        $export = new \App\Exports\ReportExport($report->data, $columns);
        
        \Maatwebsite\Excel\Facades\Excel::store($export, 'reports/' . $filename, 'public', \Maatwebsite\Excel\Excel::CSV);

        return 'reports/' . $filename;
    }
}
