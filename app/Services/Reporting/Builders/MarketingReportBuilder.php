<?php

namespace App\Services\Reporting\Builders;

use App\Services\Reporting\Contracts\ReportBuilderInterface;

class MarketingReportBuilder implements ReportBuilderInterface
{
    protected string $startDate;
    protected string $endDate;
    protected array $columns = ['*'];
    protected array $filters = [];

    public function setDateRange(string $start, string $end): self
    {
        $this->startDate = $start;
        $this->endDate = $end;
        return $this;
    }

    public function selectColumns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    public function applyFilters(array $filters): self
    {
        $this->filters = $filters;
        return $this;
    }

    public function getResult(): \App\Services\Reporting\DTOs\ReportDTO
    {
        $query = \App\Models\AnalyticsData::query()
            ->whereIn('event_type', ['signup', 'view'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if (!empty($this->filters['min_value'])) {
            $query->where('value', '>=', $this->filters['min_value']);
        }

        $data = $query->cursor();

        return new \App\Services\Reporting\DTOs\ReportDTO($data);
    }
}
