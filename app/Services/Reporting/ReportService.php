<?php

declare(strict_types=1);

namespace App\Services\Reporting;

use App\Services\Reporting\Director\ReportDirector;
use App\Services\Reporting\Exports\ExportService;
use App\Services\Reporting\Factories\ReportBuilderFactory;

class ReportService
{
    /**
     * Create a new ReportService instance.
     */
    public function __construct(
        protected ReportBuilderFactory $factory,
        protected ReportDirector $director,
        protected ExportService $exportService
    ) {}

    public function generate(string $type, array $data, string $format, ?int $templateId = null): \App\Models\GeneratedReport
    {
        // 1. Track Report Generation (Pending)
        $reportRecord = \App\Models\GeneratedReport::create([
            'report_template_id' => $templateId,
            'format' => $format,
            'status' => \App\Services\Reporting\Enums\ReportStatus::PENDING,
            'expires_at' => now()->addHours(24),
        ]);

        // 2. Create DTO
        $dto = \App\Services\Reporting\DTOs\ReportFilterDTO::fromRequest($data, $type, $format, $templateId);

        // 3. Dispatch Job
        \App\Services\Reporting\Jobs\GenerateReportExportJob::dispatch($reportRecord->id, $dto);

        return $reportRecord;
    }

    public function saveTemplate(array $data): \App\Models\ReportTemplate
    {
        return \App\Models\ReportTemplate::create([
            'name' => 'Custom Report ' . now()->toDateTimeString(), // Could be passed from input
            'report_type' => $data['report_type'] ?? 'analytics',
            'configuration' => $data,
        ]);
    }
}
