<?php

namespace App\Services\Reporting\Factories;

use App\Services\Reporting\Contracts\ReportBuilderInterface;

class ReportBuilderFactory
{
    /**
     * Create a report builder instance based on the type.
     *
     * @param string $type
     * @return ReportBuilderInterface|null
     */
    public function create(string $type): ?ReportBuilderInterface
    {
        return match ($type) {
            'sales' => new \App\Services\Reporting\Builders\SalesReportBuilder(),
            'marketing' => new \App\Services\Reporting\Builders\MarketingReportBuilder(),
            'analytics' => new \App\Services\Reporting\Builders\AnalyticsReportBuilder(),
            default => null,
        };
    }
}
