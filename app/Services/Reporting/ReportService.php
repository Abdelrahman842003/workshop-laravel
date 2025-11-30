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

    public function generate(string $type, array $data, string $format, ?int $templateId = null): string
    {
        // 1. Track Report Generation (Pending)
        $reportRecord = \App\Models\GeneratedReport::create([
            'report_template_id' => $templateId,
            'format' => $format,
            'status' => \App\Services\Reporting\Enums\ReportStatus::PENDING,
            'expires_at' => now()->addHours(24),
        ]);

        try {
            $builder = $this->factory->create($type);

            if (!$builder) {
                throw new \InvalidArgumentException("Invalid report type: {$type}");
            }

            // 2. Build Report (From Template or Manual)
            if ($templateId) {
                $template = \App\Models\ReportTemplate::findOrFail($templateId);
                $this->director->buildFromTemplate($builder, $template);
                $reportDTO = $builder->getResult();
            } else {
                $builder->setDateRange($data['start_date'], $data['end_date']);

                if (!empty($data['columns'])) {
                    $builder->selectColumns($data['columns']);
                }

                if (!empty($data['filters'])) {
                    $builder->applyFilters($data['filters']);
                }

                $reportDTO = $builder->getResult();
            }

            // 3. Export File
            $filePath = $this->exportService->export($reportDTO, $format);

            // 4. Update Record (Completed)
            $reportRecord->update([
                'path' => $filePath,
                'status' => \App\Services\Reporting\Enums\ReportStatus::COMPLETED,
                'expires_at' => now()->addDays(30),
            ]);

            return $filePath;

        } catch (\Throwable $e) {
            $reportRecord->update(['status' => \App\Services\Reporting\Enums\ReportStatus::FAILED]);
            throw $e;
        }
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
