<?php

namespace App\Services\Reporting\Director;

use App\Services\Reporting\Contracts\ReportBuilderInterface;

class ReportDirector
{
    /**
     * Build a report using the given builder.
     *
     * @param ReportBuilderInterface $builder
     * @return mixed
     */
    public function buildReport(ReportBuilderInterface $builder)
    {
        return $builder->build();
    }
}
