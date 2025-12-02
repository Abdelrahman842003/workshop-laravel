<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Enumerable;

class ReportPdfExport implements FromView
{
    public function __construct(
        protected Enumerable $data,
        protected array $columns
    ) {}

    public function view(): View
    {
        return view('reports.pdf', [
            'data' => $this->data,
            'columns' => $this->columns
        ]);
    }
}
