<?php

namespace App\Services\Reporting\DTOs;

class ReportDTO
{
    public $data;
    public $meta;

    /**
     * Create a new ReportDTO instance.
     *
     * @param mixed $data
     * @param array $meta
     */
    public function __construct($data, array $meta = [])
    {
        $this->data = $data;
        $this->meta = $meta;
    }
}
