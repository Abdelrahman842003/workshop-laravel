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
    public function export($data)
    {
        $fileName = 'report-' . now()->timestamp . '.csv';
        $filePath = storage_path('app/public/' . $fileName);

        // Ensure directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $writer = new \OpenSpout\Writer\CSV\Writer();
        $writer->openToFile($filePath);

        $headersWritten = false;

        foreach ($data->data as $row) {
            $rowArray = $row instanceof \Illuminate\Database\Eloquent\Model ? $row->toArray() : (array) $row;

            // Convert array values to JSON strings
            array_walk($rowArray, function (&$value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
            });

            if (!$headersWritten) {
                $writer->addRow(\OpenSpout\Common\Entity\Row::fromValues(array_keys($rowArray)));
                $headersWritten = true;
            }

            $writer->addRow(\OpenSpout\Common\Entity\Row::fromValues($rowArray));
        }

        $writer->close();

        return $filePath;
    }
}
