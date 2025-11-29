<?php

namespace App\Services\Reporting\Contracts;

interface ReportBuilderInterface
{
    /**
     * Set the date range for the report.
     */
    public function setDateRange(string $start, string $end): self;

    /**
     * Select specific columns for the report.
     */
    public function selectColumns(array $columns): self;

    /**
     * Apply filters to the report.
     */
    public function applyFilters(array $filters): self;

    /**
     * Get the result of the report.
     *
     * @return \App\Services\Reporting\DTOs\ReportDTO
     */
    public function getResult();
}
