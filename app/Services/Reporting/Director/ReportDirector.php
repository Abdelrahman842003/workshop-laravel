<?php

namespace App\Services\Reporting\Director;

use App\Services\Reporting\Contracts\ReportBuilderInterface;

class ReportDirector
{
    /**
     * Build a report from a template.
     *
     * @param ReportBuilderInterface $builder
     * @param \App\Models\ReportTemplate $template
     * @return void
     */
    public function buildFromTemplate(ReportBuilderInterface $builder, \App\Models\ReportTemplate $template): void
    {

        $config = $template->configuration;

        if (isset($config['start_date']) && isset($config['end_date'])) {
            $builder->setDateRange($config['start_date'], $config['end_date']);
        }

        if (!empty($config['columns'])) {
            $builder->selectColumns($config['columns']);
        }

        if (!empty($config['filters'])) {
            $builder->applyFilters($config['filters']);
        }

    }
}
