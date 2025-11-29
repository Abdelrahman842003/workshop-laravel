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
        return null;
    }
}
