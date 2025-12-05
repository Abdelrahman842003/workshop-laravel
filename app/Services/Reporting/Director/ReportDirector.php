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

    /**
     * Build a report from a DTO.
     *
     * @param ReportBuilderInterface $builder
     * @param \App\Services\Reporting\DTOs\ReportFilterDTO $dto
     * @return void
     */
    public function buildFromDto(ReportBuilderInterface $builder, \App\Services\Reporting\DTOs\ReportFilterDTO $dto): void
    {
        if ($dto->startDate && $dto->endDate) {
            $builder->setDateRange($dto->startDate, $dto->endDate);
        }

        if (!empty($dto->columns)) {
            $builder->selectColumns($dto->columns);
        }

        if (!empty($dto->filters)) {
            $builder->applyFilters($dto->filters);
        }
    }
}
