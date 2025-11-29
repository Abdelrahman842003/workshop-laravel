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
    public function export($data)
    {
        $fileName = 'report-' . now()->timestamp . '.pdf';
        $filePath = storage_path('app/public/' . $fileName);

        // Ensure directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        // Limit data to prevent memory issues
        $limitedData = $data->data->take(100)->all();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', ['data' => $limitedData]);
        $pdf->save($filePath);

        return $filePath;
    }
}
