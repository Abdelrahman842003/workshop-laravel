<?php

namespace App\Services\Reporting\Builders;

use App\Services\Reporting\Contracts\ReportBuilderInterface;

class SalesReportBuilder implements ReportBuilderInterface
{
    /**
     * Set the date range for the report.
     *
     * @param string $start
     * @param string $end
     * @return self
     */
    public function setDateRange(string $start, string $end): self
    {
        return $this;
    }

    /**
     * Select specific columns for the report.
     *
     * @param array $columns
     * @return self
     */
    public function selectColumns(array $columns): self
    {
        return $this;
    }

    /**
     * Build the report.
     *
     * @return mixed
     */
    public function build()
    {
        return null;
    }
}
