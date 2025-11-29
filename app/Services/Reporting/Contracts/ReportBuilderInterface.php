<?php

namespace App\Services\Reporting\Contracts;

interface ReportBuilderInterface
{
    /**
     * Set the date range for the report.
     *
     * @param string $start
     * @param string $end
     * @return self
     */
    public function setDateRange(string $start, string $end): self;

    /**
     * Select specific columns for the report.
     *
     * @param array $columns
     * @return self
     */
    public function selectColumns(array $columns): self;

    /**
     * Build the report.
     *
     * @return mixed
     */
    public function build();
}
