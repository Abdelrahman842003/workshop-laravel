<?php

namespace App\Services\Reporting\Exports\Strategies;

use App\Services\Reporting\Exports\Contracts\ExportStrategyInterface;

class PdfExportStrategy implements ExportStrategyInterface
{
    /**
     * Export the given data.
     *
     * @param mixed $data
     * @return mixed
     */
    public function export(\App\Services\Reporting\DTOs\ReportDTO $report, string $filename): string
    {
        // Limit PDF to 50 rows to prevent OOM
        $data = $report->data->take(50);
        
        $firstItem = $data->first();
        $columns = $firstItem ? array_keys($firstItem instanceof \Illuminate\Database\Eloquent\Model ? $firstItem->toArray() : (array) $firstItem) : [];

        $export = new \App\Exports\ReportPdfExport($data, $columns);
        
        \Maatwebsite\Excel\Facades\Excel::store($export, 'reports/' . $filename, 'public', \Maatwebsite\Excel\Excel::DOMPDF);

        return 'reports/' . $filename;
    }
}
