<?php

namespace App\Services\Reporting\Jobs;

use App\Services\Reporting\DTOs\ReportFilterDTO;
use App\Services\Reporting\Enums\ReportStatus;
use App\Services\Reporting\Exports\ExportService;
use App\Services\Reporting\Director\ReportDirector;
use App\Services\Reporting\Factories\ReportBuilderFactory;
use App\Models\GeneratedReport;
use App\Models\ReportTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateReportExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $reportId,
        protected ReportFilterDTO $dto
    ) {}

    /**
     * Execute the job.
     */
    public function handle(
        ReportBuilderFactory $factory,
        ReportDirector $director,
        ExportService $exportService
    ): void {
        $reportRecord = GeneratedReport::find($this->reportId);

        if (!$reportRecord) {
            return;
        }

        // Increase memory limit for large exports (especially PDF)
        ini_set('memory_limit', '2048M');
        set_time_limit(300); // 5 minutes

        try {
            $reportRecord->update(['status' => ReportStatus::PROCESSING]);

            $builder = $factory->create($this->dto->reportType);

            if (!$builder) {
                throw new \InvalidArgumentException("Invalid report type: {$this->dto->reportType}");
            }

            // Build Report
            // Priority: Manual Input (DTO) > Template (Director)
            // If DTO has configuration, use it. If not and Template ID exists (e.g. Scheduled Job), use Director.
            if ($this->dto->startDate && $this->dto->endDate) {
                $builder->setDateRange($this->dto->startDate, $this->dto->endDate);

                if (!empty($this->dto->columns)) {
                    $builder->selectColumns($this->dto->columns);
                }

                if (!empty($this->dto->filters)) {
                    $builder->applyFilters($this->dto->filters);
                }
            } elseif ($this->dto->templateId) {
                // Fallback: Use Director to build from Template (e.g. Scheduled Tasks)
                $template = ReportTemplate::findOrFail($this->dto->templateId);
                $director->buildFromTemplate($builder, $template);
            }

            $reportDTO = $builder->getResult();

            // Export File
            $filePath = $exportService->export($reportDTO, $this->dto->format);

            // Update Record
            $reportRecord->update([
                'path' => $filePath,
                'status' => ReportStatus::COMPLETED,
                'expires_at' => now()->addDays(30),
            ]);

            // Optional: Send Notification to User
            // $reportRecord->user->notify(new ReportGeneratedNotification($reportRecord));

        } catch (\Throwable $e) {
            $reportRecord->update(['status' => ReportStatus::FAILED]);
            \Illuminate\Support\Facades\Log::error('Report Generation Failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
