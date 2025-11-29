<?php

namespace App\Services\Reporting\DTOs;

use Illuminate\Support\Enumerable;

class ReportDTO
{
    /**
     * Create a new ReportDTO instance.
     * * @param Enumerable $data (Accepts both Collection and LazyCollection)
     * @param array $meta
     */
    public function __construct(
        public readonly Enumerable $data,
        public readonly array $meta = []
    ) {}
}