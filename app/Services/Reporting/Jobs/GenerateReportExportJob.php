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

        try {
            $reportRecord->update(['status' => ReportStatus::PROCESSING]);

            $builder = $factory->create($this->dto->reportType);

            if (!$builder) {
                throw new \InvalidArgumentException("Invalid report type: {$this->dto->reportType}");
            }

            // Build Report
            if ($this->dto->templateId) {
                $template = ReportTemplate::findOrFail($this->dto->templateId);
                $director->buildFromTemplate($builder, $template);
            } else {
                $builder->setDateRange($this->dto->startDate, $this->dto->endDate);

                if (!empty($this->dto->columns)) {
                    $builder->selectColumns($this->dto->columns);
                }

                if (!empty($this->dto->filters)) {
                    $builder->applyFilters($this->dto->filters);
                }
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
