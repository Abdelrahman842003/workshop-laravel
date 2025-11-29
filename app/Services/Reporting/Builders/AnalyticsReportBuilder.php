<?php

namespace App\Services\Reporting\Builders;

use App\Models\AnalyticsData;
use App\Services\Reporting\Contracts\ReportBuilderInterface;
use App\Services\Reporting\DTOs\ReportDTO;

class AnalyticsReportBuilder implements ReportBuilderInterface
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

    public function getResult(): ReportDTO
    {
        $query = AnalyticsData::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);

        if (!empty($this->filters['event_type'])) {
            $query->where('event_type', $this->filters['event_type']);
        }

        if (!empty($this->filters['min_value'])) {
            $query->where('value', '>=', $this->filters['min_value']);
        }

        $data = $query->cursor();
        
        return new ReportDTO($data);
    }
}
