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

    public function __construct(
        protected string $reportId,
        protected ReportFilterDTO $dto
    ) {}
        
    public function handle(
        ReportBuilderFactory $factory,
        ReportDirector $director,
        ExportService $exportService
    ): void {
        $reportRecord = GeneratedReport::find($this->reportId);

        if (!$reportRecord) {
            return;
        }

        ini_set('memory_limit', '2048M');
        set_time_limit(300);

        try {
            $reportRecord->update(['status' => ReportStatus::PROCESSING]);

            $builder = $factory->create($this->dto->reportType);

            if (!$builder) {
                throw new \InvalidArgumentException("Invalid report type: {$this->dto->reportType}");
            }

            if ($this->dto->startDate && $this->dto->endDate) {
                $director->buildFromDto($builder, $this->dto);
            } elseif ($this->dto->templateId) {
                $template = ReportTemplate::findOrFail($this->dto->templateId);
                $director->buildFromTemplate($builder, $template);
            }

            $reportDTO = $builder->getResult();

            $filePath = $exportService->export($reportDTO, $this->dto->format);

            $reportRecord->update([
                'path' => $filePath,
                'status' => ReportStatus::COMPLETED,
                'expires_at' => now()->addDays(30),
            ]);

        } catch (\Throwable $e) {
            $reportRecord->update(['status' => ReportStatus::FAILED]);
            \Illuminate\Support\Facades\Log::error('Report Generation Failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
